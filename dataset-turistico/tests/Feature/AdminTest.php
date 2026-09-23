<?php

namespace Tests\Feature;

use App\Models\Atomo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Concerns\CreaDatasetDePrueba;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use CreaDatasetDePrueba;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->crearDatasetDePrueba();
    }

    public function test_el_panel_requiere_sesion(): void
    {
        $this->get('/admin')->assertRedirect('/admin/entrar');
        $this->get('/admin/atomos/16/edit')->assertRedirect('/admin/entrar');
    }

    public function test_iniciar_sesion_con_credenciales_correctas_e_incorrectas(): void
    {
        User::factory()->create(['email' => 'admin@dataset.local', 'password' => 'secreto123']);

        $this->post('/admin/entrar', ['email' => 'admin@dataset.local', 'password' => 'mala'])
            ->assertSessionHasErrors('email');
        $this->assertGuest();

        $this->post('/admin/entrar', ['email' => 'admin@dataset.local', 'password' => 'secreto123'])
            ->assertRedirect('/admin');
        $this->assertAuthenticated();
    }

    public function test_editar_un_atomo_actualiza_datos_relaciones_y_actividades(): void
    {
        $this->actingAs(User::factory()->create());

        $this->put('/admin/atomos/68', [
            'nombre' => 'Parque del Oriente',
            'descripcion' => 'Parque con lago y ciclovía.',
            'latitud' => 16.761,
            'longitud' => -93.081,
            'origen_id' => 7,
            'activo' => '1',
            'categorias' => [1],
            'subcategorias' => [98, 46],
            'actividades' => "Caminar\n\nAndar en bicicleta\n",
        ])->assertRedirect()->assertSessionHas('exito');

        $atomo = Atomo::with(['categorias', 'actividades'])->find(68);
        $this->assertSame('Parque con lago y ciclovía.', $atomo->descripcion);
        // La subcategoría 46 (Lagos y lagunas) agrega su categoría 3.
        $this->assertSame([1, 3], $atomo->categorias->pluck('id')->all());
        $this->assertSame(['Caminar', 'Andar en bicicleta'], $atomo->actividades->pluck('descripcion')->all());
    }

    public function test_validacion_en_espanol(): void
    {
        $this->actingAs(User::factory()->create());

        $this->put('/admin/atomos/68', ['nombre' => '', 'latitud' => 500, 'longitud' => -93])
            ->assertSessionHasErrors([
                'nombre' => 'El campo nombre es obligatorio.',
                'latitud' => 'El campo latitud debe estar entre -90 y 90.',
            ]);
    }

    public function test_crear_y_eliminar_un_atomo(): void
    {
        $this->actingAs(User::factory()->create());

        $this->post('/admin/atomos', ['nombre' => 'Mirador Los Tulipanes', 'activo' => '1', 'subcategorias' => [112]])
            ->assertRedirect();

        $atomo = Atomo::where('nombre', 'Mirador Los Tulipanes')->firstOrFail();
        $this->assertSame('mirador-los-tulipanes', $atomo->slug);
        $this->assertSame([1], $atomo->categorias->pluck('id')->all());

        $this->delete("/admin/atomos/{$atomo->id}")->assertRedirect('/admin/atomos');
        $this->assertModelMissing($atomo);
    }

    public function test_subir_y_eliminar_fotos(): void
    {
        $this->actingAs(User::factory()->create());
        Storage::fake('fotos');

        $this->post('/admin/atomo/68/fotos', [
            'fotos' => [UploadedFile::fake()->image('parque.jpg', 2400, 1600)],
            'credito' => 'Ayuntamiento',
        ])->assertRedirect()->assertSessionHas('exito');

        $foto = Atomo::find(68)->fotos()->firstOrFail();
        $this->assertSame(1920, $foto->ancho);
        $this->assertSame('Ayuntamiento', $foto->credito);
        Storage::disk('fotos')->assertExists([$foto->ruta, $foto->ruta_miniatura]);

        $this->delete("/admin/fotos/{$foto->id}")->assertRedirect();
        Storage::disk('fotos')->assertMissing($foto->ruta);
    }

    public function test_paginas_del_panel(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get('/admin')->assertOk();
        $this->get('/admin/atomos?pendiente=sin_fotos')->assertOk()->assertSee('Parque del Oriente')->assertDontSee('Cañón del Sumidero');
        $this->get('/admin/atomos/create')->assertOk();
        $this->get('/admin/eventos')->assertOk()->assertSee('Feria de San Sebastián');
        $this->get('/admin/eventos/10/edit')->assertOk();
        $this->get('/admin/categorias')->assertOk()->assertSee('Cañones');
    }
}
