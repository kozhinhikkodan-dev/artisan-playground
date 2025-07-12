<?php

namespace KozhinhikkodanDev\ArtisanPlayground\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
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

        $this->registerMiddleware();
        $this->registerPolicies();
        $this->registerCommands();
        $this->registerAssetRoutes();
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

    /**
     * Register asset serving routes.
     */
    protected function registerAssetRoutes(): void
    {
        Route::get('artisan-playground/assets/{type}/{file}', function ($type, $file) {
            $assetPath = __DIR__ . "/../resources/{$type}/{$file}";

            if (!File::exists($assetPath)) {
                abort(404);
            }

            $content = File::get($assetPath);
            $mimeType = $this->getMimeType($file);

            return response($content, 200, [
                'Content-Type' => $mimeType,
                'Cache-Control' => 'public, max-age=31536000',
            ]);
        })->where('type', 'css|js')->where('file', '.*');
    }

    /**
     * Get MIME type for file.
     */
    protected function getMimeType(string $file): string
    {
        $extension = pathinfo($file, PATHINFO_EXTENSION);

        return match ($extension) {
            'css' => 'text/css',
            'js' => 'application/javascript',
            default => 'text/plain',
        };
    }
}