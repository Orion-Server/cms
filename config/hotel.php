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
     * Client configurations
     */
    'client' => [
        'nitro' => [
            'path' => env('NITRO_CLIENT_PATH', '/client'),
        ],
    ]
];
