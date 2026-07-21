<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'url' => 'required|url|max:500',
            'marketing_budget' => 'required|string',
            'cf-turnstile-response' => 'required|string',
        ]);

        if (! $this->validateTurnstile($validated['cf-turnstile-response'], $request->ip())) {
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

        $auditResult = $this->triggerTrakdAudit($domain, $validated);

        $submissionSlug = $this->saveSubmission(
            $validated,
            $domain,
            $request->ip(),
            $auditResult['audit_id'] ?? null,
            null,
            'pending'
        );

        $this->postToTrakdWebhook($validated, $domain);

        Cache::put($ipKey, $ipCount + 1, now()->addHours(self::IP_TTL_HOURS));
        Cache::put($emailKey, $emailCount + 1, now()->addDays(self::EMAIL_TTL_DAYS));

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
        if (! is_string($apiUrl) || $apiUrl === '') {
            return ['success' => true, 'audit_id' => null];
        }

        try {
            $response = Http::timeout(10)->post(
                rtrim($apiUrl, '/') . '/api/audits/start',
                [
                    'url' => 'https://' . $domain,
                    'source' => 'lead_magnet',
                    'name' => $submission['name'],
                    'email' => $submission['email'],
                ]
            );

            if ($response->successful()) {
                return [
                    'success' => true,
                    'audit_id' => $response->json('audit_id'),
                ];
            }
        } catch (\Throwable $e) {
            Log::info('Trakd audit trigger failed - falling back to email delivery', [
                'domain' => $domain,
                'error' => $e->getMessage(),
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
            Http::timeout(5)->post($webhookUrl, [
                'name' => $submission['name'],
                'email' => $submission['email'],
                'website' => $domain,
                'marketing_budget' => $submission['marketing_budget'],
                'source' => 'free_audit_lead_magnet',
                '_campaign' => 'website-audit-tool',
            ]);
        } catch (\Throwable $e) {
            Log::warning('Trakd webhook post failed', [
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
