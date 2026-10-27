<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cookie
    |--------------------------------------------------------------------------
    |
    | It's ironic, but this addon uses cookies to determine which consent groups
    | a user has consented to. Configure the name & expiry of the cookie here.
    |
    */

    'cookie_name' => 'COOKIE_NOTICE_PREFERENCES',

    'cookie_expiry' => 14,

    /*
    |--------------------------------------------------------------------------
    | Consent Widget
    |--------------------------------------------------------------------------
    |
    | Out of the box, this addon provides a simple consent widget. However, you're
    | free to create your own widget, just specify the view here.
    |
    */

    'widget_view' => 'components.cookie-notice',

    /*
    |--------------------------------------------------------------------------
    | Consent Groups
    |--------------------------------------------------------------------------
    |
    | Consent groups allow you to give your users the option to which cookies they'd
    | like to enable and which cookies they'd prefer to keep disabled.
    |
    */

    'consent_groups' => [
        [
            'name' => 'Necessary',
            'handle' => 'necessary',
            'description' => 'Essential cookies the site needs to work. Always on.',
            'enable_by_default' => true,
        ],
        [
            'name' => 'Analytics',
            'handle' => 'analytics',
            'description' => 'Help us understand how visitors use the site so we can improve it.',
            'enable_by_default' => false,
        ],
        [
            'name' => 'Advertising',
            'handle' => 'advertising',
            'description' => 'Measure the performance of our ad campaigns and show relevant ads.',
            'enable_by_default' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Scripts
    |--------------------------------------------------------------------------
    |
    | When you configure scripts in the Control Panel, they get saved to a YAML file.
    | By default, this file is saved to the `content` directory. However, you're free to
    | change this path if you'd like.
    |
    */

    'path' => base_path('content/cookie-notice.yaml'),

];
