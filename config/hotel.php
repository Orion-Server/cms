<?php

return [
    'cms' => [
        'available_languages' => [
            'en' => 'English',
            'es' => 'Spanish',
            'pt_BR' => 'Portuguese',
            'tr' => 'Turkish',
            'da' => 'Danish',
            'nl' => 'Dutch',
            'fi' => 'Finnish',
            'fr' => 'French',
        ]
    ],

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
     * Turnstile configurations
     */	
	'turnstile' => [
        'enabled' => !! env('TURNSILE_ENABLED', false),
        'site_key' => env('TURNSTILE_SITE_KEY', ''),
        'secret_key' => env('TURNSTILE_SECRET_KEY', ''),
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
        // Nitro configurations
        'nitro' => [
            'enabled' => !! env('NITRO_ENABLED', true),
            'cms_toggle_button' => true,
            'online_count_button' => true,

            /**
             * Path to the client folder (relative to the public folder)
             */
            'path' => env('NITRO_CLIENT_PATH', '/client'),
            'relative_files_path' => env('NITRO_FILES_RELATIVE_PATH', null)
        ],

        // Flash configurations
        'flash' => [
            'enabled' => !! env('FLASH_ENABLED', true),
            'cms_toggle_button' => true,
            'online_count_button' => true,

            'emulator_host' => env('EMULATOR_HOST', null),
            'emulator_port' => env('EMULATOR_PORT', null),

            'relative_files_path' => env('FLASH_FILES_RELATIVE_PATH', null),

            'loading_phrases' => [
                "When you least expect it... we'll finish loading...",
                'Loading fun message! Please wait.',
                'Follow the yellow duck.',
                'Look to one side. Look at each other. Blink twice. Ready!',
                'Loading the pixel universe.',
            ],

            'external_files' => [
                'flash_production' => env('FLASH_PRODUCTION'),
                'flash_furnidata' => env('FLASH_FURNIDATA'),
                'flash_figuremap' => env('FLASH_FIGUREMAP'),
                'flash_figuredata' => env('FLASH_FIGUREDATA'),
                'flash_productdata' => env('FLASH_PRODUCTDATA'),
                'flash_external_variables' => env('FLASH_EXTERNAL_VARIABLES'),
                'flash_external_flash_texts' => env('FLASH_EXTERNAL_FLASH_TEXTS'),
                'flash_external_override_variables' => env('FLASH_EXTERNAL_OVERRIDE_VARIABLES'),
                'flash_external_flash_override_texts' => env('FLASH_EXTERNAL_FLASH_OVERRIDE_TEXTS'),
            ]
        ]
    ]
];
