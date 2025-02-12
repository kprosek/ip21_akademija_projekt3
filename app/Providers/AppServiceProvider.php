<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerApiRoutes();
    }

    protected function registerApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->app->getNamespace())
            ->group(base_path('routes/api.php'));
    }
}
