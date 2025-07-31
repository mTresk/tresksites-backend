<?php

declare(strict_types=1);

namespace App\Providers\Filament;

use Exception;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

final class AdminPanelProvider extends PanelProvider
{
    /**
     * @throws Exception
     */
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id(id: 'admin')
            ->path(path: 'admin')
            ->login()
            ->colors(colors: [
                'primary' => '#ff565c',
            ])
            ->favicon(url: asset(path: 'images/favicon.png'))
            ->brandLogo(logo: fn () => view(view: 'filament.admin.logo'))
            ->darkModeBrandLogo(logo: fn () => view(view: 'filament.admin.logo-dark'))
            ->brandLogoHeight(height: '3rem')
            ->font(family: 'Manrope')
            ->discoverResources(in: app_path(path: 'Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path(path: 'Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages(pages: [
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path(path: 'Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets(widgets: [
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware(middleware: [
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
            ->authMiddleware(middleware: [
                Authenticate::class,
            ])
            ->viteTheme(theme: 'resources/css/filament/admin/theme.css')
            ->spa();
    }
}
