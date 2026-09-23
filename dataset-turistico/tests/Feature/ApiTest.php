<?php

namespace Tests\Feature;

use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreaDatasetDePrueba;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use CreaDatasetDePrueba;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->crearDatasetDePrueba();
    }

    public function test_el_indice_describe_la_api(): void
    {
        $this->getJson('/api/v1')
            ->assertOk()
            ->assertJsonPath('version_api', 'v1')
            ->assertJsonPath('totales.atomos', 2)
            ->assertJsonPath('totales.atomos_inactivos', 1)
            ->assertJsonStructure(['version_datos', 'recursos' => ['atomos', 'mapa'], 'descargas' => ['xml', 'json', 'csv']]);
    }

    public function test_lista_solo_activos_por_omision_y_pagina(): void
    {
        $this->getJson('/api/v1/atomos')
            ->assertOk()
            ->assertJsonCount(2, 'datos')
            ->assertJsonPath('meta.total', 2)
            ->assertJsonPath('datos.0.nombre', 'Cañón del Sumidero');

        $this->getJson('/api/v1/atomos?activo=todos&por_pagina=1&pagina=2')
            ->assertOk()
            ->assertJsonPath('meta.total', 3)
            ->assertJsonPath('meta.paginas', 3)
            ->assertJsonCount(1, 'datos');
    }

    public function test_filtra_por_categoria_subcategoria_y_origen_con_id_o_slug(): void
    {
        $this->getJson('/api/v1/atomos?categoria=ambiente-natural')->assertJsonPath('meta.total', 1);
        $this->getJson('/api/v1/atomos?categoria=1')->assertJsonPath('meta.total', 2);
        $this->getJson('/api/v1/atomos?subcategoria=canones')->assertJsonPath('datos.0.id', 16);
        $this->getJson('/api/v1/atomos?origen=tuxtla')->assertJsonPath('datos.0.id', 68);
    }

    public function test_la_busqueda_ignora_acentos_y_mayusculas(): void
    {
        $this->getJson('/api/v1/atomos?q=CANON')
            ->assertJsonPath('meta.total', 1)
            ->assertJsonPath('datos.0.slug', 'canon-del-sumidero');
    }

    public function test_busqueda_por_cercania_ordena_por_distancia(): void
    {
        $respuesta = $this->getJson('/api/v1/atomos?cerca=16.76,-93.08&radio=10')->assertOk();

        $this->assertSame([68, 16], array_column($respuesta->json('datos'), 'id'));
        $this->assertEquals(0, $respuesta->json('datos.0.distancia_km'));
        $this->assertGreaterThan(3, $respuesta->json('datos.1.distancia_km'));
    }

    public function test_un_atomo_por_id_o_slug_con_todos_sus_datos(): void
    {
        $this->getJson('/api/v1/atomos/canon-del-sumidero')
            ->assertOk()
            ->assertJsonPath('datos.id', 16)
            ->assertJsonPath('datos.coordenadas.latitud', 16.793)
            ->assertJsonPath('datos.actividades.0', 'Recorrido en lancha')
            ->assertJsonPath('datos.categorias.1.slug', 'ambiente-natural')
            ->assertJsonPath('datos.fotos.0.url', url('/fotos/1'));

        $this->getJson('/api/v1/atomos/9999')->assertNotFound()->assertJsonPath('mensaje', 'Recurso no encontrado.');
    }

    public function test_cercanos_excluye_el_propio_atomo_y_los_inactivos(): void
    {
        $this->getJson('/api/v1/atomos/16/cercanos?radio=500')
            ->assertOk()
            ->assertJsonCount(1, 'datos')
            ->assertJsonPath('datos.0.id', 68);
    }

    public function test_mapa_devuelve_geojson(): void
    {
        $this->getJson('/api/v1/mapa')
            ->assertOk()
            ->assertJsonPath('type', 'FeatureCollection')
            ->assertJsonCount(2, 'features')
            ->assertJsonPath('features.0.geometry.coordinates', [-93.0751, 16.793]);
    }

    public function test_categorias_y_origenes_con_totales(): void
    {
        $this->getJson('/api/v1/categorias')
            ->assertOk()
            ->assertJsonCount(7, 'datos')
            ->assertJsonPath('datos.0.total_atomos', 2)
            ->assertJsonPath('datos.2.total_atomos', 1);

        $this->getJson('/api/v1/origenes/chiapas')
            ->assertOk()
            ->assertJsonPath('datos.total_atomos', 1)
            ->assertJsonPath('datos.centro.latitud', 16.793);
    }

    public function test_eventos_calculan_la_proxima_fecha(): void
    {
        CarbonImmutable::setTestNow('2026-09-22');

        $this->getJson('/api/v1/eventos')
            ->assertOk()
            ->assertJsonPath('datos.0.proxima_fecha', '2027-01-12')
            ->assertJsonPath('datos.0.mes', 1);

        $this->getJson('/api/v1/eventos?mes=5')->assertJsonPath('meta.total', 0);
        $this->getJson('/api/v1/eventos?mes=13')->assertStatus(422);

        CarbonImmutable::setTestNow();
    }

    public function test_filtros_invalidos_responden_422(): void
    {
        $this->getJson('/api/v1/atomos?categoria=no-existe')->assertStatus(422)->assertJsonValidationErrors('categoria');
        $this->getJson('/api/v1/atomos?bbox=1,2,3')->assertStatus(422)->assertJsonValidationErrors('bbox');
        $this->getJson('/api/v1/atomos?cerca=abc')->assertStatus(422)->assertJsonValidationErrors('cerca');
    }

    public function test_las_respuestas_permiten_cors_y_cache(): void
    {
        $respuesta = $this->getJson('/api/v1/categorias', ['Origin' => 'http://otro-sitio.test']);

        $respuesta->assertHeader('Access-Control-Allow-Origin', '*');
        $this->assertNotEmpty($respuesta->headers->get('ETag'));
    }
}
