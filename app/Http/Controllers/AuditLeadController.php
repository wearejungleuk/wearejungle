<?php

namespace App\Http\Controllers;

use App\Mail\AuditReadyMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Statamic\Facades\Entry;

class AuditLeadController extends Controller
{
    private const IP_LIMIT = 2;
    private const IP_TTL_HOURS = 24;
    private const EMAIL_LIMIT = 3;
    private const EMAIL_TTL_DAYS = 7;
    private const DOMAIN_TTL_DAYS = 7;

    public function submit(Request $request): JsonResponse
    {
        Log::info('AuditLead submit received', [
            'ip'    => $request->ip(),
            'email' => $request->input('email'),
            'url'   => $request->input('url'),
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'url' => 'required|url|max:500',
            'marketing_budget' => 'required|string',
            'cf-turnstile-response' => 'required|string',
        ]);

        if (! $this->validateTurnstile($validated['cf-turnstile-response'], $request->ip())) {
            Log::warning('AuditLead submit rejected: turnstile failed', [
                'ip' => $request->ip(),
            ]);
            return response()->json([
                'error' => true,
                'message' => 'Security check failed. Please refresh and try again.',
            ], 422);
        }

        $domain = $this->cleanDomain($validated['url']);
        $email = strtolower(trim($validated['email']));
        $limitsEnabled = app()->isProduction();

        $ipKey = 'audit_ip_' . md5($request->ip());
        $ipCount = (int) Cache::get($ipKey, 0);
        if ($limitsEnabled && $ipCount >= self::IP_LIMIT) {
            return response()->json([
                'error' => true,
                'message' => 'You have reached the limit of ' . self::IP_LIMIT . ' free audits per day. Please try again tomorrow.',
                'ratelimit' => true,
            ], 429);
        }

        $emailKey = 'audit_email_' . md5($email);
        $emailCount = (int) Cache::get($emailKey, 0);
        if ($limitsEnabled && $emailCount >= self::EMAIL_LIMIT) {
            return response()->json([
                'error' => true,
                'message' => 'You have already requested ' . self::EMAIL_LIMIT . ' audits this week. Your latest report has been emailed to you.',
                'ratelimit' => true,
            ], 429);
        }

        $domainKey = 'audit_domain_' . md5($domain);
        $existingAudit = $limitsEnabled ? Cache::get($domainKey) : null;
        if (is_array($existingAudit) && ! empty($existingAudit['share_url'])) {
            $submissionSlug = $this->saveSubmission(
                $validated,
                $domain,
                $request->ip(),
                $existingAudit['audit_id'] ?? null,
                $existingAudit['share_url'],
                'complete'
            );
            $this->postToTrakdWebhook($validated, $domain);
            Cache::put($ipKey, $ipCount + 1, now()->addHours(self::IP_TTL_HOURS));
            Cache::put($emailKey, $emailCount + 1, now()->addDays(self::EMAIL_TTL_DAYS));

            return response()->json([
                'success' => true,
                'submission_id' => $submissionSlug,
                'share_url' => $existingAudit['share_url'],
                'cached' => true,
            ]);
        }

        Log::info('AuditLead: triggering Trakd audit', ['domain' => $domain]);
        $auditResult = $this->triggerTrakdAudit($domain, $validated);

        Log::info('AuditLead: saving submission entry', ['domain' => $domain]);
        $submissionSlug = $this->saveSubmission(
            $validated,
            $domain,
            $request->ip(),
            $auditResult['audit_id'] ?? null,
            null,
            'pending'
        );

        Log::info('AuditLead: posting webhook', ['domain' => $domain]);
        $this->postToTrakdWebhook($validated, $domain);

        Cache::put($ipKey, $ipCount + 1, now()->addHours(self::IP_TTL_HOURS));
        Cache::put($emailKey, $emailCount + 1, now()->addDays(self::EMAIL_TTL_DAYS));

        Log::info('AuditLead submit complete', [
            'domain'        => $domain,
            'submission'    => $submissionSlug,
            'audit_id'      => $auditResult['audit_id'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'submission_id' => $submissionSlug,
            'audit_id' => $auditResult['audit_id'] ?? null,
            'cached' => false,
        ]);
    }

    public function pollStatus(string $submission): JsonResponse
    {
        $entry = Entry::query()
            ->where('collection', 'audit_submissions')
            ->where('slug', $submission)
            ->first();

        if (! $entry) {
            return response()->json(['status' => 'not_found'], 404);
        }

        $status = $entry->get('trakd_audit_status', 'pending');
        $shareUrl = $entry->get('trakd_share_url');

        if ($status === 'complete' && $shareUrl) {
            return response()->json([
                'status' => 'complete',
                'share_url' => $shareUrl,
            ]);
        }

        if ($status === 'failed') {
            return response()->json(['status' => 'failed']);
        }

        return response()->json(['status' => 'pending']);
    }

    /**
     * Receiver for Trakd's audit-complete callback.
     * Trakd POSTs here when a crawl started via /api/audits/start finishes.
     * Verified by the shared TRAKD_CALLBACK_SECRET so we know the
     * request is legitimate. Updates the matching audit_submissions
     * entry so pollStatus() returns 'complete' + the report URL to
     * the frontend on its next poll.
     */
    public function receiveCallback(Request $request): JsonResponse
    {
        $expected = (string) config('services.trakd.callback_secret', '');
        if ($expected === '') {
            Log::warning('Audit callback received but TRAKD_CALLBACK_SECRET not configured');
            return response()->json(['error' => 'not_configured'], 503);
        }

        $provided = (string) $request->header('X-Callback-Secret', '');
        if (! hash_equals($expected, $provided)) {
            Log::warning('Audit callback rejected: bad secret', ['ip' => $request->ip()]);
            return response()->json(['error' => 'unauthorised'], 401);
        }

        $data = $request->validate([
            'audit_id'     => 'required',
            'public_url'   => 'required|url',
            'domain'       => 'nullable|string',
            'lead_email'   => 'nullable|email',
            'lead_name'    => 'nullable|string',
            'scores'       => 'nullable|array',
            'issues'       => 'nullable|array',
            'stats'        => 'nullable|array',
            'completed_at' => 'nullable|string',
        ]);

        $auditId = (string) $data['audit_id'];

        $entry = Entry::query()
            ->where('collection', 'audit_submissions')
            ->where('trakd_audit_id', $auditId)
            ->first();

        if (! $entry) {
            Log::warning('Audit callback: no submission matches audit_id', [
                'audit_id' => $auditId,
                'domain'   => $data['domain'] ?? null,
            ]);
            // 200 anyway — the callback did its part, we just don't have
            // a matching record to update. Preventing Trakd from
            // needlessly retrying is more useful than surfacing a 404.
            return response()->json(['ok' => true, 'matched' => false]);
        }

        $entry->set('trakd_audit_status', 'complete');
        $entry->set('trakd_share_url', $data['public_url']);
        $entry->set('trakd_audit_scores', $data['scores'] ?? []);
        $entry->set('trakd_audit_issues', $data['issues'] ?? []);
        $entry->set('trakd_audit_completed_at', $data['completed_at'] ?? now()->toIso8601String());
        $entry->save();

        // Email the lead with their report link + top-line summary.
        // Prefer the email on the callback payload (source of truth from
        // Trakd) but fall back to the one stored on the submission entry.
        // Skipped silently if we don't have any email — nothing to send to.
        $recipient = $data['lead_email'] ?? $entry->get('submitter_email');
        $leadName  = $data['lead_name']  ?? $entry->get('submitter_name');
        $alreadySent = (bool) $entry->get('audit_ready_email_sent_at');

        // Explicit trace of the send-or-skip decision so a "no email
        // arrived" report can be diagnosed from the log without guessing
        // which branch fired.
        Log::info('Audit callback: email decision', [
            'audit_id'      => $auditId,
            'recipient'     => $recipient ?: '(none)',
            'has_recipient' => (bool) $recipient,
            'already_sent'  => $alreadySent,
            'will_send'     => (bool) ($recipient && ! $alreadySent),
        ]);

        if ($recipient && ! $alreadySent) {
            try {
                Mail::to($recipient)->send(new AuditReadyMail(
                    domain:         (string) ($data['domain'] ?? $entry->get('website_url') ?? 'your website'),
                    publicUrl:      (string) $data['public_url'],
                    leadName:       $leadName ? (string) $leadName : null,
                    overallScore:   isset($data['scores']['overall'])  ? (int) $data['scores']['overall']  : null,
                    criticalIssues: isset($data['issues']['critical']) ? (int) $data['issues']['critical'] : null,
                    totalIssues:    isset($data['issues']['total'])    ? (int) $data['issues']['total']    : null,
                ));

                $entry->set('audit_ready_email_sent_at', now()->toIso8601String());
                $entry->save();

                Log::info('Audit ready email sent', [
                    'audit_id' => $auditId,
                    'to'       => $recipient,
                ]);
            } catch (\Throwable $e) {
                // Fail-soft — the callback DID land (entry updated,
                // pollStatus will unblock the on-page UI). Email being
                // separately deliverable shouldn't 500 the callback.
                Log::warning('Audit ready email send failed', [
                    'audit_id' => $auditId,
                    'to'       => $recipient,
                    'error'    => $e->getMessage(),
                ]);
            }
        }

        Log::info('Audit callback processed', [
            'audit_id' => $auditId,
            'domain'   => $data['domain'] ?? null,
            'overall'  => $data['scores']['overall'] ?? null,
        ]);

        return response()->json(['ok' => true, 'matched' => true]);
    }

    private function validateTurnstile(string $token, string $ip): bool
    {
        $workerUrl = config('turnstile.worker_url');
        if (! is_string($workerUrl) || $workerUrl === '') {
            Log::warning('Turnstile worker URL not configured');
            return false;
        }

        try {
            $response = Http::timeout(10)
                ->asJson()
                ->post($workerUrl, [
                    'token' => $token,
                    'remoteip' => $ip,
                ]);
        } catch (\Throwable $e) {
            Log::warning('Turnstile worker call failed', ['error' => $e->getMessage()]);
            return false;
        }

        return $response->successful() && $response->json('success') === true;
    }

    private function cleanDomain(string $url): string
    {
        $domain = preg_replace('/^https?:\/\//i', '', $url);
        $domain = preg_replace('/^www\./i', '', $domain);
        $domain = strtok($domain, '/');
        return strtolower(trim($domain));
    }

    private function triggerTrakdAudit(string $domain, array $submission): array
    {
        $apiUrl = config('services.trakd.api_url');
        $secret = (string) config('services.trakd.callback_secret', '');

        if (! is_string($apiUrl) || $apiUrl === '') {
            Log::warning('Trakd audit trigger skipped: TRAKD_API_URL not configured');
            return ['success' => true, 'audit_id' => null];
        }
        if ($secret === '') {
            Log::warning('Trakd audit trigger skipped: TRAKD_CALLBACK_SECRET not configured');
            return ['success' => true, 'audit_id' => null];
        }

        // Route-name lookup is behind a try in case the routes cache is
        // stale (audits.callback was added in the same deploy as this
        // method) — an unresolved route would otherwise throw and
        // silently null the audit_id. Falls back to skipping the
        // callback rather than failing the whole trigger.
        $callbackUrl = null;
        try {
            $callbackUrl = route('audits.callback');
        } catch (\Throwable $e) {
            Log::warning('audits.callback route not found — skipping callback_url', [
                'error' => $e->getMessage(),
            ]);
        }

        try {
            $payload = [
                'url'    => 'https://' . $domain,
                'source' => 'lead_magnet',
                'name'   => $submission['name'],
                'email'  => $submission['email'],
            ];
            if ($callbackUrl) {
                $payload['callback_url'] = $callbackUrl;
            }

            $response = Http::timeout(10)
                ->withHeaders(['X-Callback-Secret' => $secret])
                ->acceptJson()
                ->post(rtrim($apiUrl, '/') . '/api/audits/start', $payload);

            if ($response->successful()) {
                Log::info('Trakd audit started', [
                    'domain'    => $domain,
                    'audit_id'  => $response->json('audit_id'),
                    'public_url'=> $response->json('public_url'),
                ]);
                return [
                    'success'  => true,
                    'audit_id' => $response->json('audit_id'),
                ];
            }

            // Non-2xx — log with the body so we can see WHY (401 bad
            // secret, 503 secret not configured, 422 bad URL, etc). This
            // was previously silent, hiding real integration failures.
            Log::warning('Trakd audit trigger returned non-2xx', [
                'domain' => $domain,
                'status' => $response->status(),
                'body'   => substr($response->body(), 0, 500),
            ]);
        } catch (\Throwable $e) {
            Log::warning('Trakd audit trigger threw', [
                'domain' => $domain,
                'error'  => $e->getMessage(),
            ]);
        }

        return ['success' => true, 'audit_id' => null];
    }

    private function postToTrakdWebhook(array $submission, string $domain): void
    {
        $webhookUrl = config('services.trakd.webhook_url');
        if (! is_string($webhookUrl) || $webhookUrl === '') {
            Log::warning('Trakd webhook URL not configured - lead not sent to Trakd', [
                'email' => $submission['email'],
            ]);
            return;
        }

        try {
            $response = Http::timeout(5)->post($webhookUrl, [
                'name' => $submission['name'],
                'email' => $submission['email'],
                'website' => $domain,
                'marketing_budget' => $submission['marketing_budget'],
                'source' => 'free_audit_lead_magnet',
                '_campaign' => 'website-audit-tool',
            ]);

            // Http::post doesn't throw on 4xx/5xx — check status
            // explicitly so a failing webhook doesn't fail silently.
            if ($response->failed()) {
                Log::warning('Trakd webhook returned non-2xx', [
                    'email'  => $submission['email'],
                    'status' => $response->status(),
                    'url'    => $webhookUrl,
                    'body'   => substr($response->body(), 0, 300),
                ]);
                return;
            }

            Log::info('Trakd webhook posted', [
                'email' => $submission['email'],
                'domain' => $domain,
            ]);
        } catch (\Throwable $e) {
            Log::warning('Trakd webhook post threw', [
                'email' => $submission['email'],
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function saveSubmission(
        array $validated,
        string $domain,
        string $ip,
        ?string $auditId,
        ?string $shareUrl,
        string $status
    ): string {
        $slug = Str::slug($domain . '-' . now()->timestamp);

        Entry::make()
            ->collection('audit_submissions')
            ->slug($slug)
            ->date(now())
            ->data([
                'title' => $validated['name'] . ' - ' . $domain,
                'submitter_name' => $validated['name'],
                'submitter_email' => $validated['email'],
                'website_url' => $validated['url'],
                'marketing_budget' => $validated['marketing_budget'],
                'trakd_audit_id' => $auditId,
                'trakd_audit_status' => $status,
                'trakd_share_url' => $shareUrl,
                'ip_address' => $ip,
                'submitted_at' => now()->toIso8601String(),
                'webhook_sent' => true,
            ])
            ->save();

        return $slug;
    }
}
