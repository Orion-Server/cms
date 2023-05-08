<?php

return [
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
     * Meta data configurations
     */
    'meta' => [
        'author' => 'Nicollas#8412',
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
            'path' => env('NITRO_CLIENT_PATH', '/client'),
        ],
    ]
];
