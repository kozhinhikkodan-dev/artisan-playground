<?php

namespace KozhinhikkodanDev\ArtisanPlayground\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
use KozhinhikkodanDev\ArtisanPlayground\Middleware\ArtisanPlaygroundMiddleware;
use KozhinhikkodanDev\ArtisanPlayground\Models\ArtisanCommand;
use KozhinhikkodanDev\ArtisanPlayground\Policies\ArtisanCommandPolicy;

class ArtisanPlaygroundServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/artisan-playground.php',
            'artisan-playground'
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'artisan-playground');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        $this->publishes([
            __DIR__ . '/../config/artisan-playground.php' => config_path('artisan-playground.php'),
            __DIR__ . '/../resources/views' => resource_path('views/vendor/artisan-playground'),
        ], 'artisan-playground');

        $this->publishes([
            __DIR__ . '/../resources/css' => public_path('vendor/artisan-playground/css'),
            __DIR__ . '/../resources/js' => public_path('vendor/artisan-playground/js'),
        ], 'artisan-playground-assets');

        $this->registerAssetRoutes();
        $this->registerMiddleware();
        $this->registerPolicies();
        $this->registerCommands();
    }

    /**
     * Register middleware.
     */
    protected function registerMiddleware(): void
    {
        $this->app['router']->aliasMiddleware('artisan-playground', ArtisanPlaygroundMiddleware::class);
    }

    /**
     * Register policies.
     */
    protected function registerPolicies(): void
    {
        Gate::policy(ArtisanCommand::class, ArtisanCommandPolicy::class);
    }

    /**
     * Register asset routes for serving CSS and JS files.
     *
     * These routes ensure that package assets are always available,
     * even if the user has not published them. This allows a fresh
     * install to "just work" out of the box. Publishing is only
     * required for customization.
     */
    protected function registerAssetRoutes(): void
    {
        // Register asset routes with higher priority
        Route::group(['middleware' => 'web'], function () {
            Route::get('vendor/artisan-playground/css/{file}', function ($file) {
                $path = __DIR__ . '/../resources/css/' . $file;
                if (file_exists($path)) {
                    $content = file_get_contents($path);
                    return response($content, 200, [
                        'Content-Type' => 'text/css',
                        'Cache-Control' => 'public, max-age=31536000'
                    ]);
                }
                abort(404);
            })->where('file', '.*');

            Route::get('vendor/artisan-playground/js/{file}', function ($file) {
                $path = __DIR__ . '/../resources/js/' . $file;
                if (file_exists($path)) {
                    $content = file_get_contents($path);
                    return response($content, 200, [
                        'Content-Type' => 'application/javascript',
                        'Cache-Control' => 'public, max-age=31536000'
                    ]);
                }
                abort(404);
            })->where('file', '.*');
        });
    }

    /**
     * Register custom commands.
     */
    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \KozhinhikkodanDev\ArtisanPlayground\Console\Commands\InstallCommand::class,
            ]);
        }
    }
}