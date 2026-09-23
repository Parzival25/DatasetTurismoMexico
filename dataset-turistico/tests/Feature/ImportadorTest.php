<?php

namespace Tests\Feature;

use App\Importacion\ImportadorDataset;
use App\Models\Atomo;
use App\Models\Evento;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImportadorTest extends TestCase
{
    use RefreshDatabase;

    private string $raiz;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('fotos');
        Storage::fake('reportes');

        $this->raiz = sys_get_temp_dir().'/dataset-prueba-'.uniqid();
        $legado = "{$this->raiz}/turismo_chiapas";
        File::makeDirectory("{$legado}/atomos", 0775, true);
        File::makeDirectory("{$legado}/fotos", 0775, true);
        File::makeDirectory("{$legado}/atomos_temporales", 0775, true);
        File::makeDirectory("{$legado}/respaldo sql/20130610", 0775, true);
        File::makeDirectory("{$legado}/Yajalon/app/atomos", 0775, true);

        $this->crearJpg("{$legado}/fotos/a0101.jpg");
        $this->crearJpg("{$legado}/fotos/at0701.jpg");

        // Ficha original con acentos: alimenta el diccionario.
        File::put("{$legado}/atomos/1.html", '<html><body><div id="titulo">CASCADA</div>'
            .'<div class="tab_content">La vegetación es exuberante y turística. Visítela en época de lluvias.</div></body></html>');

        File::put("{$legado}/atomos_temporales/at7.html", '<html><body><div id="titulo">FESTIVAL MAYA ZOQUE</div>'
            .'<div class="tab_content">Fomenta la cultura de los pueblos mayas y zoques.</div>'
            .'<div class="tab_content">Tuxtla Gutiérrez</div><div class="tab_content">Centro de la ciudad</div>'
            .'<div class="tab_content">Danzas y música.</div><img src="../fotos/at0701.jpg"></body></html>');

        File::put("{$legado}/respaldo sql/20130610/atomos_temporales.sql",
            "INSERT INTO `atomos_temporales` (`AT_ID`, `AT_NOMBRE`, `AT_C1`, `AT_C2`, `AT_LATITUD`, `AT_LONGITUD`, `AT_FECHA`, `AT_PERIODO`, `AT_DESCRIPCION`, `AT_COMO_LLEGAR`, `AT_ACTIVIDADES`, `AT_FOTOS`) VALUES\n"
            ."(7, 'Festival Maya Zoque', '6.', '72.', 16.7536, -93.1161, '2013-11-15', '', '', '', '', '');\n");

        $atomos = [
            ['id' => 1, 'Nombre' => 'Cascada Escondida', 'C1' => '1,3', 'C2' => '42', 'Latitud' => '16.5', 'Longitud' => '-92.5',
                'Origen' => '1', 'NumOriginal' => '1', 'Activo' => '0',
                'Descripcion' => 'La vegetacion es exuberante y turIstica.', 'Foto2-' => '../fotos/a0101.jpg', 'Foto3' => 'Senderismo'],
            ['id' => 1, 'Nombre' => 'Duplicado', 'C1' => '2,3', 'C2' => '2946', 'Latitud' => '16.6', 'Longitud' => '93.1',
                'Origen' => '1', 'NumOriginal' => '0', 'Activo' => '1'],
            ['id' => 5, 'Nombre' => 'Auditorio Municipal.', 'C1' => '2,6,7', 'C2' => '124,73,127', 'Latitud' => '17.2', 'Longitud' => '-92.3',
                'Origen' => '6', 'NumOriginal' => '9', 'Activo' => '1'],
            ['id' => 6, 'Nombre' => 'Casa de las Sirenas', 'C1' => '4', 'C2' => '65,124', 'Latitud' => '99', 'Longitud' => '99',
                'Origen' => '5', 'NumOriginal' => '3', 'Activo' => ''],
        ];

        $xml = '<?xml version="1.0" encoding="UTF-8"?><Atomos>';
        foreach ($atomos as $atomo) {
            $atomo += ['Descripcion' => '', 'Localizacion' => '', 'ComoLLegar' => '', 'Actividad1' => '', 'Foto1' => '', 'Foto2-' => '', 'Foto3' => ''];
            $xml .= '<Atomo '.collect($atomo)->map(fn ($v, $k) => $k.'="'.htmlspecialchars($v).'"')->implode(' ').'/>';
        }
        File::put("{$this->raiz}/DataSetA.xml", $xml.'</Atomos>');

        config([
            'dataset.fuente_xml' => "{$this->raiz}/DataSetA.xml",
            'dataset.fuente_legado' => $legado,
        ]);
    }

    protected function tearDown(): void
    {
        File::deleteDirectory($this->raiz);
        parent::tearDown();
    }

    public function test_importa_y_corrige_los_problemas_conocidos(): void
    {
        $reporte = (new ImportadorDataset)->importar();

        $this->assertSame(4, Atomo::count());
        $this->assertSame(4, Atomo::where('activo', true)->count(), 'Todos se importan como activos.');

        $cascada = Atomo::with(['fotos', 'actividades', 'categorias'])->find(1);
        $this->assertSame('La vegetación es exuberante y turística.', $cascada->descripcion);
        $this->assertSame('0', $cascada->legado_activo);
        $this->assertCount(1, $cascada->fotos);
        $this->assertSame(['Senderismo'], $cascada->actividades->pluck('descripcion')->all());
        Storage::disk('fotos')->assertExists(['atomos/1/01.jpg', 'atomos/1/mini/01.jpg']);

        // Id repetido: se reasigna; código pegado "2946" => 29, 46; longitud sin signo => corregida.
        $duplicado = Atomo::where('nombre', 'Duplicado')->with('subcategorias')->first();
        $this->assertSame(7, $duplicado->id);
        $this->assertSame([29, 46], $duplicado->subcategorias->pluck('id')->all());
        $this->assertSame(-93.1, $duplicado->longitud);

        // Códigos locales de Yajalón: 124 = Básquetbol, 127 = Auditorios. Punto final del nombre eliminado.
        $auditorio = Atomo::with('subcategorias')->find(5);
        $this->assertSame('Auditorio Municipal', $auditorio->nombre);
        $this->assertSame([73, 124, 127], $auditorio->subcategorias->pluck('id')->sort()->values()->all());

        // Código 124 sin significado para San Cristóbal y coordenadas imposibles: se omiten y se reportan.
        $sirenas = Atomo::with('subcategorias')->find(6);
        $this->assertSame([65], $sirenas->subcategorias->pluck('id')->all());
        $this->assertNull($sirenas->latitud);

        $mensajes = collect($reporte->entradas())->pluck('mensaje')->implode("\n");
        $this->assertStringContainsString('ya estaba en uso', $mensajes);
        $this->assertStringContainsString('Código C2 124 sin significado', $mensajes);
        $this->assertStringContainsString('Coordenadas fuera de Chiapas', $mensajes);
        Storage::disk('reportes')->assertExists(['importacion.csv', 'importacion.json']);
    }

    public function test_importa_eventos_desde_sql_y_ficha(): void
    {
        (new ImportadorDataset)->importar();

        $evento = Evento::with(['fotos', 'subcategorias'])->find(7);
        $this->assertSame('Festival Maya Zoque', $evento->nombre);
        $this->assertSame('Fomenta la cultura de los pueblos mayas y zoques.', $evento->descripcion);
        $this->assertSame('Tuxtla Gutiérrez', $evento->localizacion);
        $this->assertSame('2013-11-15', $evento->fecha->toDateString());
        $this->assertSame([72], $evento->subcategorias->pluck('id')->all());
        $this->assertCount(1, $evento->fotos);
    }

    public function test_reimportar_reemplaza_todo(): void
    {
        (new ImportadorDataset)->importar();
        (new ImportadorDataset(conFotos: false))->importar();

        $this->assertSame(4, Atomo::count());
        $this->assertSame(1, Evento::count());
    }

    private function crearJpg(string $ruta): void
    {
        $imagen = imagecreatetruecolor(800, 600);
        imagefill($imagen, 0, 0, imagecolorallocate($imagen, 30, 120, 90));
        imagejpeg($imagen, $ruta);
        imagedestroy($imagen);
    }
}
