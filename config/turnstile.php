<?php

return [

    'site_key' => env('TURNSTILE_SITE_KEY'),

    'worker_url' => env('TURNSTILE_WORKER_URL'),

    'exclusions' => [
        // 'contact_us',
    ],
];
