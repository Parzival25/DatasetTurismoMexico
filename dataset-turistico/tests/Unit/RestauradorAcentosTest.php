<?php

namespace Tests\Unit;

use App\Importacion\RestauradorAcentos;
use PHPUnit\Framework\TestCase;

class RestauradorAcentosTest extends TestCase
{
    private function restaurador(): RestauradorAcentos
    {
        $conteos = [];
        RestauradorAcentos::contarPalabras(
            'La vegetación del área es única. Está en México, cerca del río. El río es grande. '
            .'Esta cascada está lejos; esta ruta está cerrada. Publicó el público. Tumbalá.',
            $conteos
        );

        return new RestauradorAcentos(RestauradorAcentos::construirDiccionario($conteos));
    }

    public function test_restaura_palabras_que_solo_aparecen_con_acento(): void
    {
        $this->assertSame(
            'La vegetación del área es única en México y Tumbalá',
            $this->restaurador()->restaurar('La vegetacion del area es unica en Mexico y Tumbala')
        );
    }

    public function test_respeta_mayusculas(): void
    {
        $r = $this->restaurador();

        $this->assertSame('MÉXICO', $r->restaurarPalabra('MEXICO'));
        $this->assertSame('Área', $r->restaurarPalabra('Area'));
    }

    public function test_no_toca_palabras_ambiguas(): void
    {
        $r = $this->restaurador();

        $this->assertSame('esta', $r->restaurarPalabra('esta'));
        $this->assertSame('publico', $r->restaurarPalabra('publico'));
    }

    public function test_corrige_la_i_mayuscula_de_la_conversion_original(): void
    {
        $r = new RestauradorAcentos;

        $this->assertSame('ecoturístico', $r->restaurarPalabra('ecoturIstico'));
        $this->assertSame('ahí', $r->restaurarPalabra('ahI'));
        $this->assertSame('Ríos', $r->restaurarPalabra('RIos'));
        $this->assertSame('DIF', $r->restaurarPalabra('DIF'));
    }

    public function test_agrega_tilde_a_terminaciones_cion_y_sion(): void
    {
        $r = new RestauradorAcentos;

        $this->assertSame('Descripción', $r->restaurarPalabra('Descripcion'));
        $this->assertSame('expresión', $r->restaurarPalabra('expresion'));
        $this->assertSame('descripciones', $r->restaurarPalabra('descripciones'));
    }
}
