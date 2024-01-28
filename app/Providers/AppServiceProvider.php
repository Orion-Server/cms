<?php

namespace App\Providers;

use Filament\Facades\Filament;
use App\Services\ProfileService;
use App\Services\SettingsService;
use App\Enums\ArticleReactionType;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Filament\Navigation\NavigationGroup;
use App\Services\Parsers\ExternalTextsParser;
use Srmklive\PayPal\Services\PayPal;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ExternalTextsParser::class, fn () => new ExternalTextsParser());
        $this->app->singleton(SettingsService::class, fn () => new SettingsService());
        $this->app->singleton(ProfileService::class, fn () => new ProfileService());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->bootGlobalViewVariables();

        if (App::isProduction() && config('hotel.force_https')) {
            URL::forceScheme('https');
        }

        $this->bindPaypalInstance();
        $this->bootDashboardSettings();
    }

    private function bindPaypalInstance(): void
    {
        $this->app->bind(PayPal::class, function() {
            $provider = new PayPal(config('paypal'));
            $provider->getAccessToken();

            return $provider;
        });
    }

    /**
     * Bootstrap the global view variables.
     */
    private function bootGlobalViewVariables(): void
    {
        View::share('fromClient', request()->has('fromClient'));
        View::share('unsupportedFlashClient', request()->has('unsupported_flash'));

        View::share('availableLanguages', config('hotel.cms.available_languages'));
        View::share('articleReactions', collect(ArticleReactionType::cases()));
    }

    /**
     * Bootstrap the dashboard settings.
     */
    private function bootDashboardSettings(): void
    {
        Filament::serving(function() {
            Filament::registerStyles([asset('assets/css/ckeditor.css')]);
            Filament::registerViteTheme('resources/scss/filament.scss');

            $getNavigationLabel = fn (string $label) => __("filament::resources.navigations.{$label}");

            Filament::registerNavigationGroups([
                NavigationGroup::make()
                    ->label($getNavigationLabel('Dashboard'))
                    ->collapsible(false),

                NavigationGroup::make()
                    ->label($getNavigationLabel('Website'))
                    ->collapsed(),

                NavigationGroup::make()
                    ->label($getNavigationLabel('Shop'))
                    ->collapsed(),

                NavigationGroup::make()
                    ->label($getNavigationLabel('Help Center'))
                    ->collapsed(),

                NavigationGroup::make()
                    ->label($getNavigationLabel('Hotel'))
                    ->collapsed(),

                NavigationGroup::make()
                    ->label($getNavigationLabel('Administration'))
                    ->collapsed(),

                NavigationGroup::make()
                    ->label($getNavigationLabel('User Management'))
                    ->collapsed(),

                NavigationGroup::make()
                    ->label($getNavigationLabel('Profile Management'))
                    ->collapsed()
            ]);
        });
    }
}
