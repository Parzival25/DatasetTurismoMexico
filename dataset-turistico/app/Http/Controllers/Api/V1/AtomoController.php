<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Presentadores\AtomoPresentador;
use App\Models\Atomo;
use App\Support\ConsultaAtomos;
use App\Support\Geo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException;

class AtomoController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $completo = $request->query('incluir') === 'completo';
        $consulta = ConsultaAtomos::aplicar(Atomo::query(), $request)
            ->with($completo ? AtomoPresentador::RELACIONES_COMPLETAS : AtomoPresentador::RELACIONES);
        $porPagina = $this->porPagina($request);
        $cerca = ConsultaAtomos::cerca($request);

        if ($cerca) {
            $caja = Geo::caja($cerca['lat'], $cerca['lng'], $cerca['radio']);
            $conDistancia = $consulta
                ->whereBetween('latitud', [$caja['lat_min'], $caja['lat_max']])
                ->whereBetween('longitud', [$caja['lng_min'], $caja['lng_max']])
                ->get()
                ->map(fn (Atomo $a) => [$a, Geo::distanciaKm($cerca['lat'], $cerca['lng'], $a->latitud, $a->longitud)])
                ->filter(fn ($par) => $par[1] <= $cerca['radio'])
                ->sortBy(fn ($par) => $par[1])
                ->values();

            $pagina = LengthAwarePaginator::resolveCurrentPage('pagina');
            $paginador = new LengthAwarePaginator(
                $conDistancia->forPage($pagina, $porPagina)->values(),
                $conDistancia->count(),
                $porPagina,
                $pagina,
                ['path' => $request->url(), 'pageName' => 'pagina']
            );

            return $this->paginado($paginador, $request, fn ($par) => $completo
                ? AtomoPresentador::completo($par[0], $par[1])
                : AtomoPresentador::resumen($par[0], $par[1]));
        }

        $orden = $request->query('orden', 'nombre');
        match ($orden) {
            'nombre' => $consulta->orderBy('nombre'),
            'id' => $consulta->orderBy('id'),
            'recientes' => $consulta->latest('updated_at'),
            default => throw ValidationException::withMessages(['orden' => 'Valores permitidos: nombre, id, recientes.']),
        };

        $paginador = $consulta->paginate($porPagina, ['*'], 'pagina');

        return $this->paginado($paginador, $request, fn (Atomo $a) => $completo
            ? AtomoPresentador::completo($a)
            : AtomoPresentador::resumen($a));
    }

    public function show(Atomo $atomo): JsonResponse
    {
        $atomo->load(AtomoPresentador::RELACIONES_COMPLETAS);

        return response()->json(['datos' => AtomoPresentador::completo($atomo)]);
    }

    public function cercanos(Request $request, Atomo $atomo): JsonResponse
    {
        if (! $atomo->tieneCoordenadas()) {
            return response()->json(['datos' => []]);
        }

        $limite = min(max((int) $request->query('limite', 6), 1), 50);
        $radio = min(max((float) $request->query('radio', 30), 0.1), 500);
        $caja = Geo::caja($atomo->latitud, $atomo->longitud, $radio);

        $cercanos = Atomo::activos()
            ->whereKeyNot($atomo->id)
            ->whereBetween('latitud', [$caja['lat_min'], $caja['lat_max']])
            ->whereBetween('longitud', [$caja['lng_min'], $caja['lng_max']])
            ->with(AtomoPresentador::RELACIONES)
            ->get()
            ->map(fn (Atomo $a) => [$a, Geo::distanciaKm($atomo->latitud, $atomo->longitud, $a->latitud, $a->longitud)])
            ->filter(fn ($par) => $par[1] <= $radio)
            ->sortBy(fn ($par) => $par[1])
            ->take($limite)
            ->map(fn ($par) => AtomoPresentador::resumen($par[0], $par[1]))
            ->values();

        return response()->json([
            'datos' => $cercanos,
            'meta' => ['radio_km' => $radio, 'limite' => $limite, 'origen' => $atomo->id],
        ]);
    }

    private function porPagina(Request $request): int
    {
        $config = config('dataset.api');

        return min(max((int) $request->query('por_pagina', $config['por_pagina']), 1), $config['por_pagina_maximo']);
    }

    private function paginado(LengthAwarePaginator $paginador, Request $request, callable $transformar): JsonResponse
    {
        $paginador->appends($request->except('pagina'));

        return response()->json([
            'datos' => $paginador->getCollection()->map($transformar)->values(),
            'meta' => [
                'pagina' => $paginador->currentPage(),
                'por_pagina' => $paginador->perPage(),
                'total' => $paginador->total(),
                'paginas' => $paginador->lastPage(),
            ],
            'enlaces' => [
                'primera' => $paginador->url(1),
                'anterior' => $paginador->previousPageUrl(),
                'siguiente' => $paginador->nextPageUrl(),
                'ultima' => $paginador->url($paginador->lastPage()),
            ],
        ]);
    }
}
