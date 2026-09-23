<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Presentadores\EventoPresentador;
use App\Models\Evento;
use App\Support\Texto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EventoController extends Controller
{
    /**
     * Filtros: mes=1..12, q=texto, activo=1|0|todos.
     * orden=proximos (por omisión: el más cercano primero) | nombre | fecha.
     */
    public function index(Request $request): JsonResponse
    {
        $consulta = Evento::query()->with(EventoPresentador::RELACIONES);

        $activo = $request->query('activo', '1');
        if ($activo !== 'todos') {
            $consulta->where('activo', filter_var($activo, FILTER_VALIDATE_BOOLEAN));
        }

        if ($texto = trim((string) $request->query('q'))) {
            foreach (explode(' ', Texto::normalizar($texto)) as $termino) {
                $consulta->where('busqueda', 'like', '%'.addcslashes($termino, '%_\\').'%');
            }
        }

        $eventos = $consulta->get();

        if ($mes = $request->query('mes')) {
            if (! ctype_digit((string) $mes) || $mes < 1 || $mes > 12) {
                throw ValidationException::withMessages(['mes' => 'El mes debe ser un número del 1 al 12.']);
            }
            $eventos = $eventos->filter(fn (Evento $e) => $e->fecha?->month === (int) $mes);
        }

        $eventos = match ($request->query('orden', 'proximos')) {
            'proximos' => $eventos->sortBy(fn (Evento $e) => $e->proximaFecha()?->timestamp ?? PHP_INT_MAX),
            'nombre' => $eventos->sortBy('nombre'),
            'fecha' => $eventos->sortBy(fn (Evento $e) => $e->fecha?->format('md') ?? '9999'),
            default => throw ValidationException::withMessages(['orden' => 'Valores permitidos: proximos, nombre, fecha.']),
        };

        return response()->json([
            'datos' => $eventos->map(fn (Evento $e) => EventoPresentador::resumen($e))->values(),
            'meta' => ['total' => $eventos->count()],
        ]);
    }

    public function show(Evento $evento): JsonResponse
    {
        $evento->load(EventoPresentador::RELACIONES);

        return response()->json(['datos' => EventoPresentador::completo($evento)]);
    }
}
