<?php

namespace App\Providers;

use App\Models\Atomo;
use App\Models\Evento;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Relation::enforceMorphMap([
            'atomo' => Atomo::class,
            'evento' => Evento::class,
        ]);

        Paginator::defaultView('parciales.paginacion');

        RateLimiter::for('api', fn (Request $request) => Limit::perMinute(240)->by($request->ip()));
    }
}
