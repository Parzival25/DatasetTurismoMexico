<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Presentadores\CatalogoPresentador;
use App\Models\Categoria;
use App\Models\Origen;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CatalogoController extends Controller
{
    public function categorias(): JsonResponse
    {
        return response()->json([
            'datos' => $this->consultaCategorias()->get()
                ->map(fn (Categoria $c) => CatalogoPresentador::categoria($c))->values(),
        ]);
    }

    public function categoria(Categoria $categoria): JsonResponse
    {
        $categoria = $this->consultaCategorias()->findOrFail($categoria->id);

        return response()->json(['datos' => CatalogoPresentador::categoria($categoria)]);
    }

    public function origenes(): JsonResponse
    {
        $resumenes = $this->resumenOrigenes();

        return response()->json([
            'datos' => Origen::orderBy('id')->get()
                ->map(fn (Origen $o) => CatalogoPresentador::origen($o, $resumenes[$o->id] ?? $this->resumenVacio()))
                ->values(),
        ]);
    }

    public function origen(Origen $origen): JsonResponse
    {
        $resumen = $this->resumenOrigenes()[$origen->id] ?? $this->resumenVacio();

        return response()->json(['datos' => CatalogoPresentador::origen($origen, $resumen)]);
    }

    private function consultaCategorias(): Builder
    {
        $soloActivos = fn ($q) => $q->where('activo', true);

        return Categoria::query()
            ->orderBy('orden')
            ->withCount(['atomos' => $soloActivos])
            ->with(['subcategorias' => fn ($q) => $q->withCount(['atomos' => $soloActivos, 'eventos' => $soloActivos])]);
    }

    /**
     * @return array<int, array{total: int, lat_min: ?float, lat_max: ?float, lng_min: ?float, lng_max: ?float}>
     */
    private function resumenOrigenes(): array
    {
        return DB::table('atomos')
            ->where('activo', true)
            ->groupBy('origen_id')
            ->selectRaw('origen_id, count(*) as total, min(latitud) as lat_min, max(latitud) as lat_max, min(longitud) as lng_min, max(longitud) as lng_max')
            ->get()
            ->mapWithKeys(fn ($fila) => [$fila->origen_id => (array) $fila])
            ->all();
    }

    private function resumenVacio(): array
    {
        return ['total' => 0, 'lat_min' => null, 'lat_max' => null, 'lng_min' => null, 'lng_max' => null];
    }
}
