<?php

namespace App\Providers;

use App\Services\ProfileService;
use App\Services\SettingsService;
use App\Enums\ArticleReactionType;
use App\Services\FindRetrosService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Srmklive\PayPal\Services\PayPal;
use Illuminate\Support\ServiceProvider;
use App\Services\Parsers\ExternalTextsParser;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;

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
        $this->app->singleton(FindRetrosService::class, fn () => new FindRetrosService());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->bootGlobalViewHelpers();

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
    private function bootGlobalViewHelpers(): void
    {
        View::share('fromClient', request()->has('fromClient'));
        View::share('unsupportedFlashClient', request()->has('unsupported_flash'));

        View::share('availableLanguages', config('hotel.cms.available_languages'));
        View::share('articleReactions', collect(ArticleReactionType::cases()));
        View::share('headerBackground', getSetting('header_background_image', 'https://i.imgur.com/XLnDlUr.png'));
        View::share('logo', getSetting('logo_image', 'https://i.imgur.com/ZqE16Ph.png'));
        View::share('logoSize', explode('x', getSetting('logo_size', '263x59')));
        View::share('usingNitroImager', getSetting('using_nitro_imager', true));
    }

    /**
     * Bootstrap the dashboard settings.
     */
    private function bootDashboardSettings(): void
    {
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $flags = [];
            $availableLanguages = array_keys(config('hotel.cms.available_languages'));

            foreach ($availableLanguages as $language) {
                $flags[$language] = asset("assets/images/country-flags/{$language}.png");
            }

            $switch->locales(array_keys(config('hotel.cms.available_languages')))
                ->labels(config('hotel.cms.available_languages'))
                ->flags($flags);
        });
    }
}
