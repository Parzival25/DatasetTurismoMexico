<?php

namespace App\Providers;

use App\Servicios\ClienteDataset;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ClienteDataset::class, fn () => ClienteDataset::desdeConfiguracion());
    }

    public function boot(): void
    {
        Paginator::defaultView('parciales.paginacion');
    }
}
