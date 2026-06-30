<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Statamic\Events\FormSubmitted;

class VerifyTurnstile
{
    public function handle(FormSubmitted $event): void
    {
        if (in_array($event->submission->form->handle(), config('turnstile.exclusions', []))) {
            return;
        }

        $token = request()->input('cf-turnstile-response');

        if (! is_string($token) || $token === '') {
            $this->fail('missing_token', 'Bot check did not load. Please refresh the page and try again.');
        }

        $workerUrl = config('turnstile.worker_url');

        if (! is_string($workerUrl) || $workerUrl === '') {
            $this->fail('config_error', 'Bot check is not configured. Please try again later.');
        }

        try {
            $response = Http::timeout(10)
                ->asJson()
                ->post($workerUrl, [
                    'token'    => $token,
                    'remoteip' => request()->ip(),
                ]);
        } catch (\Throwable $e) {
            Log::warning('Turnstile worker call failed', ['error' => $e->getMessage()]);
            $this->fail('worker_unreachable', 'We could not verify you are not a robot. Please try again.');
        }

        $verified = $response->successful() && $response->json('success') === true;

        if (! $verified) {
            $this->fail('verify_failed', 'We could not verify you are not a robot. Please try again.', [
                'http_status'  => $response->status(),
                'error_codes'  => $response->json('error-codes'),
            ]);
        }
    }

    /**
     * @return never
     */
    private function fail(string $reason, string $message, array $extra = []): void
    {
        Log::info('Turnstile validation failed', array_merge([
            'reason'    => $reason,
            'has_token' => is_string(request()->input('cf-turnstile-response')) && request()->input('cf-turnstile-response') !== '',
            'ip'        => request()->ip(),
            'ua'        => request()->userAgent(),
        ], $extra));

        throw ValidationException::withMessages(['captcha' => $message]);
    }
}
