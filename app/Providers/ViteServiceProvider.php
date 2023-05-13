<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class ViteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Vite::useScriptTagAttributes([
            'data-turbolinks-eval' => 'false'
        ]);

        Vite::useStyleTagAttributes([
            'data-turbolinks-eval' => 'false'
        ]);
    }
}
