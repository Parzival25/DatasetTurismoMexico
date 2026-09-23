<?php

namespace App\Http\Controllers;

use App\Servicios\ClienteDataset;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class EventoController extends Controller
{
    public function index(ClienteDataset $dataset): View
    {
        $eventos = $dataset->eventos(['orden' => 'fecha']);

        $porMes = collect($eventos)
            ->groupBy(fn ($e) => $e['mes'] ?? 0)
            ->sortKeys()
            ->mapWithKeys(fn ($grupo, $mes) => [
                $mes ? ucfirst(Carbon::create(2000, $mes, 1)->translatedFormat('F')) : 'Sin fecha' => $grupo,
            ]);

        return view('eventos.index', [
            'porMes' => $porMes,
            'proximo' => $dataset->eventos(['orden' => 'proximos'])[0] ?? null,
        ]);
    }

    public function show(string $slug, ClienteDataset $dataset): View
    {
        $evento = $dataset->evento($slug);
        abort_if($evento === null, 404);

        return view('eventos.show', ['evento' => $evento]);
    }
}
