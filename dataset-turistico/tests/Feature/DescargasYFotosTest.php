<?php

namespace Tests\Feature;

use App\Models\Atomo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreaDatasetDePrueba;
use Tests\TestCase;

class DescargasYFotosTest extends TestCase
{
    use CreaDatasetDePrueba;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->crearDatasetDePrueba();
    }

    public function test_json_incluye_atomos_eventos_y_catalogo(): void
    {
        $json = $this->get('/descargas/DataSetB.json')->assertOk()->json();

        $this->assertCount(3, $json['atomos']);
        $this->assertCount(1, $json['eventos']);
        $this->assertCount(7, $json['categorias']);
        $this->assertSame('Cañón del Sumidero', $json['atomos'][0]['nombre']);
    }

    public function test_xml_es_valido_y_conserva_acentos(): void
    {
        $contenido = $this->get('/DataSetA.xml')->assertOk()->assertHeader('Content-Type', 'application/xml; charset=UTF-8')->getContent();
        $xml = simplexml_load_string($contenido);

        $this->assertNotFalse($xml);
        $this->assertCount(3, $xml->atomos->atomo);
        $this->assertSame('Cañón del Sumidero', (string) $xml->atomos->atomo[0]->nombre);
        $this->assertSame('85', (string) $xml->atomos->atomo[0]->subcategorias->subcategoria[1]['id']);
    }

    public function test_csv_tiene_bom_encabezado_y_una_fila_por_atomo(): void
    {
        $contenido = $this->get('/descargas/DataSetC.csv')->assertOk()->getContent();
        $lineas = array_filter(explode("\n", $contenido));

        $this->assertStringStartsWith("\xEF\xBB\xBF", $contenido);
        $this->assertStringContainsString('id;slug;nombre', $lineas[0]);
        $this->assertCount(4, $lineas);
    }

    public function test_las_descargas_se_renuevan_al_editar_un_atomo(): void
    {
        $this->get('/descargas/DataSetB.json')->assertSee('Cañón del Sumidero');

        $this->travel(1)->minutes();
        Atomo::find(16)->update(['nombre' => 'Cañón del Sumidero (editado)']);

        $this->get('/descargas/DataSetB.json')->assertSee('Cañón del Sumidero (editado)');
    }

    public function test_descargar_agrega_content_disposition(): void
    {
        $this->get('/descargas/DataSet.geojson?descargar=1')
            ->assertOk()
            ->assertHeader('Content-Disposition', 'attachment; filename="DataSet.geojson"');
    }

    public function test_sirve_fotos_y_404_si_no_existen(): void
    {
        $this->get('/fotos/1')->assertOk()->assertHeader('Content-Type', 'image/jpeg');
        $this->get('/fotos/1/miniatura')->assertOk();
        $this->get('/fotos/999')->assertNotFound();
    }

    public function test_paginas_del_portal(): void
    {
        $this->get('/')->assertOk()->assertSee('Conjunto de datos turísticos');
        $this->get('/explorar?q=sumidero')->assertOk()->assertSee('Cañón del Sumidero')->assertDontSee('Parque del Oriente');
        $this->get('/explorar/canon-del-sumidero')->assertOk()->assertSee('Recorrido en lancha');
        $this->get('/documentacion')->assertOk()->assertSee('/api/v1/atomos');
        $this->get('/acerca')->assertOk();
    }
}
