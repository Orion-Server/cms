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

        // Dashboard configuration
        Filament::serving(function() {
            Filament::registerStyles([
                asset('assets/css/ckeditor.css')
            ]);

            Filament::registerNavigationGroups([
                NavigationGroup::make()
                    ->label('Dashboard')
                    ->collapsed()
                    ->icon('heroicon-s-server'),

                NavigationGroup::make()
                    ->label('Website')
                    ->collapsed()
                    ->icon('heroicon-s-desktop-computer'),

                NavigationGroup::make()
                    ->label('Hotel')
                    ->collapsed()
                    ->icon('heroicon-s-office-building'),

                NavigationGroup::make()
                    ->label('Administration')
                    ->collapsed()
                    ->icon('heroicon-s-adjustments'),
            ]);
        });
    }
}
