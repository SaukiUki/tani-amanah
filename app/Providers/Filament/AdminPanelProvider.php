<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->sidebarCollapsibleOnDesktop()
            ->login()
            ->brandName('Tani Amanah')
            ->font('Plus Jakarta Sans')
            ->colors([
                'primary' => Color::hex('#1E3F2B'),
                'warning' => Color::hex('#D97706'),
            ])
            ->renderHook(
                PanelsRenderHook::HEAD_START,
                fn (): string => '<link rel="preconnect" href="https://fonts.googleapis.com">' .
                    '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' .
                    '<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Newsreader:ital,opsz,wght@0,6..72,400..700;1,6..72,400..700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">'
            )
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn (): string => '<style>
                    /* Dashboard icons & indicators styling */
                    .fi-wi-stats-overview-stat-description .fi-icon {
                        width: 1rem !important;
                        height: 1rem !important;
                        min-width: 1rem !important;
                        min-height: 1rem !important;
                        display: inline-block !important;
                        vertical-align: middle !important;
                        flex-shrink: 0 !important;
                    }
                    .fi-wi-stats-overview-stat-label-ctn .fi-icon {
                        width: 1.25rem !important;
                        height: 1.25rem !important;
                        flex-shrink: 0 !important;
                    }
                    .fi-widget svg {
                        max-width: 100%;
                    }
                </style>'
            )
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                \App\Filament\Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                \App\Filament\Widgets\StatsOverviewWidget::class,
                \App\Filament\Widgets\SalamContractsTableWidget::class,
                \App\Filament\Widgets\VillageAmanahReportWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
