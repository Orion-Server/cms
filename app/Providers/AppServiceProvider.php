<?php

namespace App\Providers;

use App\Services\SettingsService;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SettingsService::class, function () {
            return new SettingsService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (App::isProduction()) {
            URL::forceScheme('https');
        }

        Filament::serving(function() {
            Filament::registerStyles([
                asset('assets/css/ckeditor.css')
            ]);

            Filament::registerNavigationGroups([
                NavigationGroup::make()->label('Hotel'),
                NavigationGroup::make()->label('Administration'),
            ]);
        });
    }
}
