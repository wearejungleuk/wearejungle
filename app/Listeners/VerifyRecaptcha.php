<?php

namespace App\Listeners;

use Anakadote\StatamicRecaptcha\Services\RecaptchaEnterprise;
use Anakadote\StatamicRecaptcha\Services\RecaptchaV2;
use Anakadote\StatamicRecaptcha\Services\RecaptchaV3;
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
        $message = __('recaptcha::recaptcha.recaptcha_error_message');

        if ($version === 'v2') {
            $response = request()->input('g-recaptcha-response');

            if (! is_string($response) || $response === '' || ! RecaptchaV2::verify($response)) {
                throw ValidationException::withMessages([$message]);
            }

            return;
        }

        if ($version === 'enterprise' || $version === 'v3') {
            $token  = request()->input('captcha_token');
            $action = request()->input('captcha_action');

            if (! is_string($token) || $token === '' || ! is_string($action) || $action === '') {
                throw ValidationException::withMessages([$message]);
            }

            $verified = $version === 'enterprise'
                ? RecaptchaEnterprise::verify($token, $action, config('recaptcha.recaptcha_enterprise.threshold'))
                : RecaptchaV3::verify($token, $action, config('recaptcha.recaptcha_v3.threshold'));

            if (! $verified) {
                throw ValidationException::withMessages([$message]);
            }

            return;
        }

        throw ValidationException::withMessages(['reCAPTCHA version not set correctly in config/recaptcha.php']);
    }
}
