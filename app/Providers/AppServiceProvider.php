<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ProveedorServicioService;
use App\Services\CotizacionService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ProveedorServicioService::class, function ($app) {
            return new ProveedorServicioService(
                $app->make('App\Http\Controllers\ProveedorController'),
                $app->make('App\Http\Controllers\ServicioController'),
                $app->make('App\Http\Controllers\PrecioController')
            );
        });

        $this->app->bind(CotizacionService::class, function ($app) {
            return new CotizacionService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
