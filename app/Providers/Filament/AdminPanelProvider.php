<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Login;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Enums\ThemeMode;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
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
            ->login(Login::class)
            ->brandName('RadarLeb Admin')
            ->brandLogo(asset('assets/imgs/logo.png'))
            ->brandLogoHeight('2.5rem')
            ->colors($this->getRadarLebColors())
            ->defaultThemeMode(ThemeMode::Dark)
            ->darkMode(true)
            ->font('Inter')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->navigationGroups([
                'Prizes',
                'Users',
                'Winners',
                'Manage RadarLeb',
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
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }

    /**
     * Get RadarLeb brand color palette.
     * Supports both light and dark themes via Filament's theming system.
     */
    protected function getRadarLebColors(): array
    {
        return [
            'primary' => [
                50 => '239, 246, 255',
                100 => '219, 234, 254',
                200 => '191, 219, 254',
                300 => '147, 197, 253',
                400 => '96, 165, 250',
                500 => '107, 186, 206',  // #6bbace - RadarLeb primary blue/cyan
                600 => '102, 175, 219',  // #66afdb - RadarLeb primary variant
                700 => '79, 140, 200',   // Darker blue for hover states
                800 => '67, 120, 180',   // Even darker for active states
                900 => '55, 100, 160',   // Darkest blue
                950 => '30, 60, 100',    // Deepest blue
            ],
            'danger' => [
                50 => '254, 242, 242',
                100 => '254, 226, 226',
                200 => '254, 202, 202',
                300 => '252, 165, 165',
                400 => '248, 113, 113',
                500 => '255, 118, 118',  // #ff7676 - RadarLeb accent red
                600 => '234, 51, 35',     // #ea3323 - RadarLeb accent variant
                700 => '220, 38, 38',
                800 => '185, 28, 28',
                900 => '153, 27, 27',
                950 => '69, 10, 10',
            ],
            'success' => [
                50 => '240, 253, 244',
                100 => '220, 252, 231',
                200 => '187, 247, 208',
                300 => '134, 239, 172',
                400 => '74, 222, 128',
                500 => '6, 172, 6',      // #06ac06 - RadarLeb success green
                600 => '5, 150, 5',
                700 => '4, 120, 4',
                800 => '3, 100, 3',
                900 => '2, 80, 2',
                950 => '1, 50, 1',
            ],
            'gray' => Color::Slate,
        ];
    }
}
