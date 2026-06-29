<?php

namespace App\Listeners;

use Anakadote\StatamicRecaptcha\Services\RecaptchaEnterprise;
use Anakadote\StatamicRecaptcha\Services\RecaptchaV2;
use Anakadote\StatamicRecaptcha\Services\RecaptchaV3;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Statamic\Events\FormSubmitted;

class VerifyRecaptcha
{
    public function handle(FormSubmitted $event): void
    {
        if (in_array($event->submission->form->handle(), config('recaptcha.exclusions', []))) {
            return;
        }

        $version = config('recaptcha.recaptcha_version');

        if ($version === 'v2') {
            $response = request()->input('g-recaptcha-response');

            if (! is_string($response) || $response === '') {
                $this->fail('missing_token', 'reCAPTCHA did not load. Please refresh the page and try again.');
            }

            if (! RecaptchaV2::verify($response)) {
                $this->fail('verify_failed', 'We could not verify you are not a robot. Please try again.');
            }

            return;
        }

        if ($version === 'enterprise' || $version === 'v3') {
            $token  = request()->input('captcha_token');
            $action = request()->input('captcha_action');

            if (! is_string($token) || $token === '' || ! is_string($action) || $action === '') {
                $this->fail('missing_token', 'reCAPTCHA did not load. Please refresh the page and try again.');
            }

            $verified = $version === 'enterprise'
                ? RecaptchaEnterprise::verify($token, $action, config('recaptcha.recaptcha_enterprise.threshold'))
                : RecaptchaV3::verify($token, $action, config('recaptcha.recaptcha_v3.threshold'));

            if (! $verified) {
                $this->fail('verify_failed', 'We could not verify you are not a robot. Please try again.');
            }

            return;
        }

        $this->fail('config_error', 'reCAPTCHA version not set correctly.');
    }

    /**
     * @return never
     */
    private function fail(string $reason, string $message): void
    {
        Log::info('reCAPTCHA validation failed', [
            'reason'    => $reason,
            'has_token' => is_string(request()->input('captcha_token')) && request()->input('captcha_token') !== '',
            'action'    => request()->input('captcha_action'),
            'ip'        => request()->ip(),
            'ua'        => request()->userAgent(),
        ]);

        throw ValidationException::withMessages(['captcha' => $message]);
    }
}
