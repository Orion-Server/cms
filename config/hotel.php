<?php

return [
    /**
     * Forces the HTTPS protocol
     */
    'force_https' => !! env('FORCE_HTTPS', true),

    /**
     * Rcon configurations
     */
    'rcon' => [
        'enabled' => !! env('RCON_ENABLED', false),
        'host' => env('RCON_HOST', '127.0.0.1'),
        'port' => env('RCON_PORT', 3001),
        'domain' => AF_INET,
        'type' => SOCK_STREAM,
        'protocol' => SOL_TCP,
    ],

    /**
     * Recaptcha configurations
     */
    'recaptcha' => [
        'enabled' => !! env('RECAPTCHA_ENABLED', false),
        'site_key' => env('RECAPTCHA_SITE_KEY', ''),
        'secret_key' => env('RECAPTCHA_SECRET_KEY', ''),
    ],

    /**
     * Meta data configurations
     */
    'meta' => [
        'author' => 'inicollas',
        'title' => 'OrionCMS - An open-source project for retros management',
        'description' => 'Join us: https://discord.com/invite/Kb7USXupCT',
        'keywords' => 'habbo, habbo hotel, friends, games',
        'image' => 'assets/images/logo.png',
        'twitter' => '@Twitter'
    ],

    /**
     * Client configurations
     */
    'client' => [
        'nitro' => [
            'cms_toggle_button' => true,
            'online_count_button' => true,
            'path' => env('NITRO_CLIENT_PATH', '/client'),
        ],
    ]
];
