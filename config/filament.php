<?php

use Filament\Support\Commands\FileGenerators\FileGenerationFlag;

return [

    /*
    |--------------------------------------------------------------------------
    | File Generation
    |--------------------------------------------------------------------------
    |
    | This panel predates Filament v4's directory layout, so the `make:filament-*`
    | generators are told to keep emitting the v3 shape: resource and cluster
    | classes next to (not inside) their directories, schemas and tables embedded
    | in the resource class, and partial imports such as `use Filament\Tables;`.
    |
    | Without these, generated code would not match the ~120 existing files under
    | app/Filament.
    |
    */

    'file_generation' => [

        'flags' => [
            FileGenerationFlag::EMBEDDED_PANEL_RESOURCE_SCHEMAS,
            FileGenerationFlag::EMBEDDED_PANEL_RESOURCE_TABLES,
            FileGenerationFlag::PANEL_CLUSTER_CLASSES_OUTSIDE_DIRECTORIES,
            FileGenerationFlag::PANEL_RESOURCE_CLASSES_OUTSIDE_DIRECTORIES,
            FileGenerationFlag::PARTIAL_IMPORTS,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Broadcasting
    |--------------------------------------------------------------------------
    |
    | By uncommenting the Laravel Echo configuration, you may connect Filament
    | to any Pusher-compatible websockets server.
    |
    | This will allow your users to receive real-time notifications.
    |
    */

    'broadcasting' => [

        // 'echo' => [
        //     'broadcaster' => 'pusher',
        //     'key' => env('VITE_PUSHER_APP_KEY'),
        //     'cluster' => env('VITE_PUSHER_APP_CLUSTER'),
        //     'wsHost' => env('VITE_PUSHER_HOST'),
        //     'wsPort' => env('VITE_PUSHER_PORT'),
        //     'wssPort' => env('VITE_PUSHER_PORT'),
        //     'authEndpoint' => '/api/v1/broadcasting/auth',
        //     'disableStats' => true,
        //     'encrypted' => true,
        // ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | This is the storage disk Filament will use to put media. You may use any
    | of the disks defined in the `config/filesystems.php`.
    |
    */

    'default_filesystem_disk' => env('FILAMENT_FILESYSTEM_DISK', 'public'),

    /*
    |--------------------------------------------------------------------------
    | Assets Path
    |--------------------------------------------------------------------------
    |
    | This is the directory where Filament's assets will be published to. It
    | is relative to the `public` directory of your Laravel application.
    |
    | After changing the path, you should run `php artisan filament:assets`.
    |
    */

    'assets_path' => null,

    /*
    |--------------------------------------------------------------------------
    | Livewire Loading Delay
    |--------------------------------------------------------------------------
    |
    | This sets the delay before loading indicators appear.
    |
    | Setting this to 'none' makes indicators appear immediately, which can be
    | desirable for high-latency connections. Setting it to 'default' applies
    | Livewire's standard 200ms delay.
    |
    */

    'livewire_loading_delay' => 'default',

];
