<?php

namespace App\Providers;

use App\Models\User;
use App\Services\ProfileService;
use App\Services\SettingsService;
use App\Enums\ArticleReactionType;
use App\Services\CacheTimeService;
use App\Services\FindRetrosService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Srmklive\PayPal\Services\PayPal;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Tables\Table;
use App\Services\Parsers\ExternalTextsParser;
use BezhanSalleh\LanguageSwitch\LanguageSwitch;

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

        if (config('hotel.force_https')) {
            URL::forceScheme('https');
        }

        $this->bindPaypalInstance();
        $this->bootDashboardSettings();
        $this->bootFilamentDefaults();
    }

    /**
     * Keep the Filament v3 defaults that v4 changed.
     *
     * These are global defaults applied at construction, so any component that
     * sets its own value explicitly still wins.
     */
    private function bootFilamentDefaults(): void
    {
        // v4 makes Grid/Section/Fieldset consume a single column instead of the
        // full row, which collapses every layout in this panel to half width.
        Grid::configureUsing(fn (Grid $component) => $component->columnSpanFull());
        Section::configureUsing(fn (Section $component) => $component->columnSpanFull());
        Fieldset::configureUsing(fn (Fieldset $component) => $component->columnSpanFull());

        Table::configureUsing(fn (Table $table) => $table
            // v4 defers filters, so every SelectFilter would need an extra "Apply" click.
            ->deferFilters(false)
            // v4 dropped 'all' from the default page options.
            ->paginationPageOptions([5, 10, 25, 50, 'all']));
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
     *
     * These are resolved through a view composer rather than `View::share()` so that
     * neither the database (`getSetting()`) nor the current request is touched while
     * the container is still booting. Booting-time reads break under `config:cache`
     * and `filament:cache-components`, and would bake a stale request into the
     * shared data on long-lived workers.
     */
    private function bootGlobalViewHelpers(): void
    {
        View::composer('*', function ($view) {
            // `SettingsService` is a singleton that loads the whole `cms_settings`
            // table once per container, so these reads do not hit the database again.
            $view->with([
                'fromClient' => request()->has('fromClient'),
                'unsupportedFlashClient' => request()->has('unsupported_flash'),

                'availableLanguages' => config('hotel.cms.available_languages'),
                'articleReactions' => collect(ArticleReactionType::cases()),
                'headerBackground' => getSetting('header_background_image', 'https://i.imgur.com/XLnDlUr.png'),
                'logo' => getSetting('logo_image', 'https://i.imgur.com/ZqE16Ph.png'),
                'logoSize' => explode('x', getSetting('logo_size', '263x59')),
                'usingNitroImager' => getSetting('using_nitro_imager', true),
            ]);
        });
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
