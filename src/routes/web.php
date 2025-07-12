<?php

use Illuminate\Support\Facades\Route;
use KozhinhikkodanDev\ArtisanPlayground\Controllers\ArtisanPlaygroundController;
use KozhinhikkodanDev\ArtisanPlayground\Controllers\AuthController;

$config = config('artisan-playground.routes');
$prefix = $config['prefix'] ?? 'artisan-playground';
$middleware = $config['middleware'] ?? ['web'];
$namespace = $config['namespace'] ?? 'KozhinhikkodanDev\\ArtisanPlayground\\Controllers';

Route::prefix($prefix)->namespace($namespace)->group(function () use ($middleware) {
    // Authentication routes
    Route::middleware(array_diff($middleware, ['artisan-playground']))->group(function () {
        Route::get('login', [AuthController::class, 'showLoginForm'])->name('artisan-playground.login');
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout'])->name('artisan-playground.logout');
    });

    // Protected routes
    Route::middleware($middleware)->group(function () {
        // Dashboard
        Route::get('/', [ArtisanPlaygroundController::class, 'index'])->name('artisan-playground.dashboard');

        // Command routes
        Route::get('command/{commandName}', [ArtisanPlaygroundController::class, 'showCommand'])->name('artisan-playground.command');
        Route::post('execute', [ArtisanPlaygroundController::class, 'executeCommand'])->name('artisan-playground.execute');

        // History
        Route::get('history', [ArtisanPlaygroundController::class, 'history'])->name('artisan-playground.history');
    });
});