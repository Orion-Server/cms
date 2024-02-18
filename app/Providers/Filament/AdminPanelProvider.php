<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\Pages\Page;
use Filament\PanelProvider;
use App\Filament\Pages\Login;
use Filament\Enums\ThemeMode;
use Filament\Support\Assets\Css;
use App\Filament\Pages\BadgePage;
use App\Filament\Pages\Dashboard;
use Filament\Support\Colors\Color;
use App\Http\Middleware\VerifyLocale;
use App\Http\Middleware\VerifyPunishments;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use App\Http\Middleware\RedirectIfTwoFactorDisabled;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use App\Filament\Resources\DashboardResource\Widgets\LatestOrders;
use App\Filament\Resources\DashboardResource\Widgets\OrdersAggregateChart;
use App\Filament\Resources\DashboardResource\Widgets\TopDashboardOverview;
use App\Filament\Resources\DashboardResource\Widgets\ArticlesAggregateChart;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $topNavigationEnabled = getSetting('hk_top_navigation_enabled', '0') === '1';
        $defaultTheme = getSetting('default_cms_mode', 'light') === 'dark' ? ThemeMode::Dark : ThemeMode::Light;

        Page::alignFormActionsEnd();

        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->colors([
                'primary' => Color::Blue,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class,
                BadgePage::class
            ])
            ->topNavigation($topNavigationEnabled)
            ->defaultThemeMode($defaultTheme)
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                TopDashboardOverview::class,
                OrdersAggregateChart::class,
                ArticlesAggregateChart::class,
                LatestOrders::class
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                VerifyLocale::class,
                VerifyPunishments::class,
                RedirectIfTwoFactorDisabled::class
            ])
            ->brandLogo(asset('assets/images/logo.gif'))
            ->favicon(asset('assets/images/panel_favicon.gif'))
            ->sidebarCollapsibleOnDesktop()
            ->authMiddleware([
                Authenticate::class,
            ])
            ->assets([
                Css::make('ckeditor-stylesheet', asset('assets/css/ckeditor.css')),
                Css::make('scrollbar-stylesheet', asset('assets/css/filament.css'))
            ]);
    }
}
