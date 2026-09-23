<?php

namespace Database\Seeders;

use App\Models\Platillo;
use App\Models\RegionGastronomica;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Revista de gastronomía del Prototipo 1: una página de presentación por
 * región (02RR_region.jpg) y las recetas de cada una (03RRNN_platillo.jpg).
 */
class GastronomiaSeeder extends Seeder
{
    private const REGIONES = [
        '01' => ['centro', 'Centro'],
        '02' => ['altos', 'Altos'],
        '03' => ['fronteriza', 'Fronteriza'],
        '04' => ['frailesca', 'Frailesca'],
        '05' => ['norte', 'Norte'],
        '06' => ['selva', 'Selva'],
        '07' => ['sierra', 'Sierra'],
        '08' => ['soconusco', 'Soconusco'],
        '09' => ['costa', 'Costa'],
    ];

    private const ACENTOS = [
        'albondigon' => 'albondigón', 'chipilin' => 'chipilín', 'azafran' => 'azafrán',
        'platano' => 'plátano', 'robalo' => 'róbalo', 'frijol' => 'frijol',
    ];

    public function run(): void
    {
        Platillo::query()->delete();
        RegionGastronomica::query()->delete();

        $archivos = collect(glob(public_path('img/gastronomia/*.jpg')))->map(fn ($f) => basename($f))->sort()->values();

        foreach (self::REGIONES as $codigo => [$slug, $nombre]) {
            $region = RegionGastronomica::create([
                'slug' => $slug,
                'nombre' => $nombre,
                'imagen' => $archivos->first(fn ($a) => str_starts_with($a, "02{$codigo}_")),
                'orden' => (int) $codigo,
            ]);

            $archivos
                ->filter(fn ($a) => str_starts_with($a, "03{$codigo}"))
                ->values()
                ->each(fn ($archivo, $i) => $region->platillos()->create([
                    'nombre' => $this->nombreDesdeArchivo($archivo),
                    'imagen' => $archivo,
                    'orden' => $i + 1,
                ]));
        }
    }

    private function nombreDesdeArchivo(string $archivo): string
    {
        $texto = str_replace('_', ' ', preg_replace('/^\d+_|\.jpg$/', '', $archivo));
        $texto = strtr($texto, self::ACENTOS);

        return Str::ucfirst($texto);
    }
}
