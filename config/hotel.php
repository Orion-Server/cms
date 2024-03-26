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
            'de' => 'German',
        ],

        'register' => [
            'register_looks' => [
                'M' => [
                    'hd-180-1.hr-828-61.he-3070-92.ch-806-92.lg-275-110.sh-305-92',
                    'hd-180-8.ch-255-82.sh-295-62.hr-841-39.lg-275-1408.ea-1406-62',
                    'lg-3088-91-77.hr-831-45.ha-1012-98.hd-3091-2.sh-290-1195.ch-3050-77-75',
                    'ha-1020-62.wa-9001123-68.lg-6141545-79-92.ch-562082-93-62.hr-831-45.sh-905-62.hd-180-2'
                ],
                'F' => [
                    'hd-3096-1.hr-9534-61.he-3071-1431.fa-1212-62.ch-3183-66.cc-3390-110.cp-3124-62.lg-3174-110.sh-3354-110',
                    'hd-600-1.sh-735-68.hr-515-33.lg-716-66-62.ch-635-70',
                    'hd-3096-3.hr-3040-1403.ha-1004-96.he-1608-62.fa-3276-1412.ch-660-73.cc-3289-96.ca-1816-62.lg-3138-1413.sh-3154-92',
                    'hd-600-3.hr-9534-1347.he-1610-62.ch-665-92.cc-3246-1327.lg-3006-98.sh-3206-62'
                ]
            ]
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
