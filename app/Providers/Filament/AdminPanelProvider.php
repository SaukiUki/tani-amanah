<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
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
            ->renderHook(
                PanelsRenderHook::SIMPLE_PAGE_START,
                fn (): string => '
                    <div class="flex flex-col items-center text-center mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#1E3F2B] to-[#142B1E] text-white flex items-center justify-center shadow-md mb-3 border border-white/20">
                            <svg class="w-7 h-7 text-[#F4F1EA]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18m0-18c-3.5 0-6 2.5-6 6 0 5 6 9 6 12m0-18c3.5 0 6 2.5 6 6 0 5-6 9-6 12" />
                            </svg>
                        </div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-widest bg-[#E8F3EB] text-[#1E3F2B] border border-[#2C543B]/20 mb-2">
                            <span class="w-2 h-2 rounded-full bg-[#1E3F2B] animate-pulse"></span>
                            <span>KOPERASI TANI PANOSOGAN • SERANG</span>
                        </div>
                        <p class="text-xs text-stone-500 max-w-xs leading-relaxed">
                            Portal Dasbor Kemitraan Salam & Transparansi Lumbung Pangan Desa
                        </p>
                    </div>'
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
            ->navigationItems([
                NavigationItem::make('Simulasi Bot WA Petani')
                    ->url(fn (): string => route('whatsapp.simulator'))
                    ->icon(Heroicon::OutlinedChatBubbleLeftRight)
                    ->sort(10)
                    ->openUrlInNewTab(),
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
