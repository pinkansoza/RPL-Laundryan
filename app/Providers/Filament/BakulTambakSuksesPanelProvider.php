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
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;

class BakulTambakSuksesPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('bakulTambakSukses')
            ->path('bakulTambakSukses')
            ->profile()
            ->login()
            ->colors([
                'primary' => Color::Sky,
            ])
            ->font('Poppins')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
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
            ])
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn (): string => Blade::render('
                    <link rel="manifest" href="/manifest.json">
                    <meta name="theme-color" content="#0ea5e9">
                    <link rel="apple-touch-icon" href="/images/pwa-icon.svg">
                ')
            )
            ->renderHook(
                PanelsRenderHook::BODY_START,
                fn (): string => Blade::render('
                    <style>
                        #app-loading-screen {
                            position: fixed;
                            top: 0;
                            left: 0;
                            width: 100vw;
                            height: 100vh;
                            background-color: #ffffff;
                            z-index: 999999;
                            display: flex;
                            flex-direction: column;
                            justify-content: center;
                            align-items: center;
                            transition: opacity 0.5s ease-out, visibility 0.5s ease-out;
                        }
                        .dark #app-loading-screen {
                            background-color: #18181b;
                        }
                        .loader-spinner {
                            width: 50px;
                            height: 50px;
                            border: 4px solid #e5e7eb;
                            border-top: 4px solid #0ea5e9;
                            border-radius: 50%;
                            animation: spin 1s linear infinite;
                            margin-bottom: 20px;
                        }
                        .dark .loader-spinner {
                            border: 4px solid #3f3f46;
                            border-top: 4px solid #0ea5e9;
                        }
                        @keyframes spin {
                            0% { transform: rotate(0deg); }
                            100% { transform: rotate(360deg); }
                        }
                        .loader-text {
                            font-family: \'Poppins\', sans-serif;
                            color: #4b5563;
                            font-size: 16px;
                            font-weight: 500;
                            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
                        }
                        .dark .loader-text {
                            color: #a1a1aa;
                        }
                        @keyframes pulse {
                            0%, 100% { opacity: 1; }
                            50% { opacity: .5; }
                        }
                    </style>
                    <div id="app-loading-screen">
                        <div class="loader-spinner"></div>
                        <div class="loader-text">Memuat Dashboard...</div>
                    </div>
                ')
            )
            ->renderHook(
                PanelsRenderHook::BODY_END,
                fn (): string => Blade::render('
                    <script>
                        window.addEventListener("load", function() {
                            const loader = document.getElementById("app-loading-screen");
                            if(loader) {
                                loader.style.opacity = "0";
                                loader.style.visibility = "hidden";
                                setTimeout(() => loader.remove(), 500);
                            }

                            if ("serviceWorker" in navigator) {
                                navigator.serviceWorker.register("/sw.js").then(function(registration) {
                                    console.log("ServiceWorker registration successful");
                                }, function(err) {
                                    console.log("ServiceWorker registration failed: ", err);
                                });
                            }
                        });
                    </script>
                ')
            );
    }
}
