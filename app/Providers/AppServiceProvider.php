<?php

namespace App\Providers;

use App\Listeners\VerifyRecaptcha;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Statamic\Events\FormSubmitted;
use Statamic\Statamic;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Vendor listener calls RecaptchaV3::verify(string $token, ...) with strict types, so a missing
        // captcha_token (ad blocker, slow grecaptcha load, JS off, bot post) throws TypeError → 500.
        // Swap in our defensive version that returns a ValidationException.
        $this->app->booted(function (): void {
            Event::forget(FormSubmitted::class);
            Event::listen(FormSubmitted::class, [VerifyRecaptcha::class, 'handle']);
        });

        // Statamic::vite('app', [
        //     'resources/js/cp.js',
        //     'resources/css/cp.css',
        // ]);
    }
}
