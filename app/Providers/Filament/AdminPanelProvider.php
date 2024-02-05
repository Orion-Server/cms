<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use App\Filament\Pages\Dashboard;
use App\Http\Middleware\VerifyLocale;
use App\Http\Middleware\VerifyPunishments;
use Filament\FontProviders\GoogleFontProvider;
use Filament\Support\Colors\Color;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $getNavigationLabel = fn (string $label) => __("filament::resources.navigations.{$label}");

        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Blue,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->spa()
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
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
            ])
            ->navigationGroups([
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
                    ->collapsed(),

                NavigationGroup::make()
                    ->label($getNavigationLabel('Logs'))
                    ->collapsed(),
            ])
            ->brandLogo(asset('assets/images/logo.gif'))
            ->favicon(asset('assets/images/panel_favicon.gif'))
            ->sidebarCollapsibleOnDesktop()
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
