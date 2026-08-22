<?php

use App\Http\Middleware\TrimTrailingSlash;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // 301 trailing-slash URLs to their non-trailing equivalent. Prepended
        // so the redirect fires before Statamic renders anything. Production
        // is nginx, so the public/.htaccess trailing-slash rule never runs.
        $middleware->prepend(TrimTrailingSlash::class);

        // Exempt the Trakd audit-complete callback from CSRF — it's a
        // server-to-server POST authenticated by the shared
        // X-Callback-Secret header, not a browser session.
        $middleware->validateCsrfTokens(except: [
            'api/audits/callback',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
