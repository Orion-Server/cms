<?php

namespace App\Providers;

use Filament\Facades\Filament;
use App\Services\SettingsService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Filament\Navigation\NavigationGroup;

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
        View::share('fromClient', request()->has('fromClient'));
        View::share('isMaintenance', getSetting('maintenance'));

        if (App::isProduction()) {
            URL::forceScheme('https');
        }

        // Dashboard configuration
        Filament::serving(function() {
            Filament::registerStyles([asset('assets/css/ckeditor.css')]);
            Filament::registerViteTheme('resources/scss/filament.scss');

            Filament::registerNavigationGroups([
                NavigationGroup::make()
                    ->label('Dashboard')
                    ->collapsible(false)
                    ->icon('heroicon-s-server'),

                NavigationGroup::make()
                    ->label('Website')
                    ->collapsed()
                    ->icon('heroicon-s-desktop-computer'),

                NavigationGroup::make()
                    ->label('Help Center')
                    ->collapsed()
                    ->icon('heroicon-o-support'),

                NavigationGroup::make()
                    ->label('Hotel')
                    ->collapsed()
                    ->icon('heroicon-s-office-building'),

                NavigationGroup::make()
                    ->label('Administration')
                    ->collapsed()
                    ->icon('heroicon-s-adjustments'),

                NavigationGroup::make()
                    ->label('User Management')
                    ->collapsed()
                    ->icon('heroicon-s-user'),
            ]);
        });
    }
}
