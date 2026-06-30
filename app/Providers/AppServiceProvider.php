<?php

namespace App\Providers;

use App\Listeners\VerifyTurnstile;
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
        // Remove the vendor reCAPTCHA listener (anakadote/statamic-recaptcha) and verify
        // Cloudflare Turnstile via the Spin siteverify Worker instead.
        $this->app->booted(function (): void {
            Event::forget(FormSubmitted::class);
            Event::listen(FormSubmitted::class, [VerifyTurnstile::class, 'handle']);
        });

        // Statamic::vite('app', [
        //     'resources/js/cp.js',
        //     'resources/css/cp.css',
        // ]);
    }
}
