<?php

namespace App\Http\Presentadores;

use App\Models\Evento;
use Illuminate\Support\Str;

class EventoPresentador
{
    public const RELACIONES = ['subcategorias', 'fotos'];

    public static function resumen(Evento $evento): array
    {
        $portada = $evento->fotos->first();
        $proxima = $evento->proximaFecha();

        return [
            'id' => $evento->id,
            'slug' => $evento->slug,
            'nombre' => $evento->nombre,
            'extracto' => $evento->descripcion ? Str::limit($evento->descripcion, 180) : null,
            'fecha_registrada' => $evento->fecha?->toDateString(),
            'proxima_fecha' => $proxima?->toDateString(),
            'mes' => $evento->fecha?->month,
            'dia' => $evento->fecha?->day,
            'periodo' => $evento->periodo,
            'recurrente' => $evento->recurrente,
            'coordenadas' => $evento->latitud !== null && $evento->longitud !== null
                ? ['latitud' => $evento->latitud, 'longitud' => $evento->longitud]
                : null,
            'activo' => $evento->activo,
            'subcategorias' => $evento->subcategorias->map(fn ($s) => CatalogoPresentador::subcategoriaCorta($s))->all(),
            'portada' => $portada ? FotoPresentador::corta($portada) : null,
            'total_fotos' => $evento->fotos->count(),
            'enlaces' => [
                'api' => route('api.eventos.show', $evento->id),
            ],
            'actualizado' => $evento->updated_at?->toIso8601String(),
        ];
    }

    public static function completo(Evento $evento): array
    {
        $resumen = self::resumen($evento);

        return array_merge(
            array_slice($resumen, 0, 3),
            [
                'descripcion' => $evento->descripcion,
                'localizacion' => $evento->localizacion,
                'como_llegar' => $evento->como_llegar,
                'actividades' => $evento->actividades,
            ],
            array_slice($resumen, 4),
            ['fotos' => $evento->fotos->map(fn ($f) => FotoPresentador::completa($f))->all()],
        );
    }
}
