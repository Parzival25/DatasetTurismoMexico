<?php

namespace Tests\Concerns;

use App\Models\Atomo;
use App\Models\Categoria;
use App\Models\Evento;
use App\Models\Origen;
use App\Models\Subcategoria;
use App\Support\Catalogo;
use App\Support\Texto;
use Illuminate\Support\Facades\Storage;

trait CreaDatasetDePrueba
{
    protected function crearCatalogo(): void
    {
        foreach (Catalogo::origenes() as $id => $origen) {
            Origen::create($origen + ['id' => $id]);
        }

        $orden = 1;
        foreach (Catalogo::categorias() as $id => $categoria) {
            Categoria::create($categoria + ['id' => $id, 'orden' => $orden++]);
        }

        $slugs = [];
        foreach (Catalogo::subcategorias() as $id => [$categoriaId, $nombre]) {
            Subcategoria::create(['id' => $id, 'categoria_id' => $categoriaId, 'nombre' => $nombre, 'slug' => Texto::slugUnico($nombre, $slugs)]);
        }
    }

    /**
     * Tres átomos en Tuxtla y alrededores, uno inactivo, y un evento.
     */
    protected function crearDatasetDePrueba(): void
    {
        $this->crearCatalogo();
        Storage::fake('fotos');

        $sumidero = Atomo::create([
            'id' => 16, 'slug' => 'canon-del-sumidero', 'nombre' => 'Cañón del Sumidero',
            'descripcion' => 'Imponente formación de piedra de 32 kilómetros.', 'localizacion' => 'A 5 km de Tuxtla Gutiérrez.',
            'como_llegar' => 'Por la calzada al Sumidero.', 'latitud' => 16.793, 'longitud' => -93.0751, 'origen_id' => 1,
            'numero_original' => 16, 'activo' => true,
        ]);
        $sumidero->categorias()->sync([1, 3]);
        $sumidero->subcategorias()->sync([84, 85]);
        $sumidero->actividades()->create(['descripcion' => 'Recorrido en lancha', 'orden' => 1]);
        Storage::disk('fotos')->put('atomos/16/01.jpg', 'jpg');
        $sumidero->fotos()->create(['ruta' => 'atomos/16/01.jpg', 'ruta_miniatura' => null, 'orden' => 1]);

        $parque = Atomo::create([
            'id' => 68, 'slug' => 'parque-del-oriente', 'nombre' => 'Parque del Oriente',
            'descripcion' => 'Parque público con áreas verdes.', 'latitud' => 16.76, 'longitud' => -93.08, 'origen_id' => 7, 'activo' => true,
        ]);
        $parque->categorias()->sync([1]);
        $parque->subcategorias()->sync([98]);

        $inactivo = Atomo::create([
            'id' => 200, 'slug' => 'agua-azul', 'nombre' => 'Agua Azul',
            'descripcion' => 'Cascadas de color turquesa.', 'latitud' => 17.5943, 'longitud' => -91.9061, 'origen_id' => 4, 'activo' => false,
        ]);
        $inactivo->categorias()->sync([3]);
        $inactivo->subcategorias()->sync([42]);

        $evento = Evento::create([
            'id' => 10, 'slug' => 'feria-de-san-sebastian', 'nombre' => 'Feria de San Sebastián',
            'descripcion' => 'La Fiesta Grande de Chiapa de Corzo.', 'fecha' => '2013-01-12', 'recurrente' => true,
            'latitud' => 16.7076, 'longitud' => -93.0173, 'activo' => true,
        ]);
        $evento->subcategorias()->sync([81, 95]);
    }
}
