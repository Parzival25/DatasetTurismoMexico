<?php

namespace App\Importacion;

use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * Restaura los acentos que se perdieron al generar DataSetA.xml.
 *
 * Construye un diccionario a partir de las fichas HTML y los volcados SQL
 * originales (que sí conservan los acentos): para cada palabra sin tilde se
 * guarda su forma acentuada solo cuando esa forma domina claramente en el
 * corpus. Las palabras ambiguas (esta/está, el/él, como/cómo...) no se tocan.
 */
class RestauradorAcentos
{
    private const TILDES = [
        'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'ü' => 'u',
        'Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U', 'Ü' => 'U',
    ];

    private const AMBIGUAS = [
        'el', 'tu', 'mi', 'si', 'se', 'de', 'te', 'mas', 'solo', 'aun', 'que', 'como', 'donde',
        'cuando', 'quien', 'quienes', 'cual', 'cuales', 'cuanto', 'esta', 'este', 'estas', 'estos',
        'ese', 'esa', 'esos', 'esas', 'aquel', 'aquella', 'publico', 'practico', 'ultimo', 'transito',
        'animo', 'termino', 'deposito', 'hacia', 'habia', 'sabia', 'seria', 'estan', 'esten',
    ];

    private const CARPETAS_IGNORADAS = '/(fancybox|galleria|bootstrap|shadowbox|fonts|engine1?|data1?|node_modules|\bjs\b)/i';

    /** @param array<string, string> $diccionario */
    public function __construct(private array $diccionario = [])
    {
    }

    public static function desdeCorpus(string $directorio): self
    {
        $conteos = [];

        if (is_dir($directorio)) {
            $iterador = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($directorio, FilesystemIterator::SKIP_DOTS)
            );

            foreach ($iterador as $archivo) {
                $ruta = $archivo->getPathname();
                $extension = strtolower($archivo->getExtension());

                if (! in_array($extension, ['html', 'htm', 'sql'], true)
                    || preg_match(self::CARPETAS_IGNORADAS, str_replace($directorio, '', $ruta))) {
                    continue;
                }

                $texto = LectorLegado::leerTexto($ruta);
                if ($extension !== 'sql') {
                    $texto = LectorLegado::htmlATexto($texto);
                }

                self::contarPalabras($texto, $conteos);
            }
        }

        return new self(self::construirDiccionario($conteos));
    }

    /**
     * @param  array<string, int>  $conteos
     */
    public static function contarPalabras(string $texto, array &$conteos): void
    {
        preg_match_all('/\p{L}+/u', $texto, $palabras);

        foreach ($palabras[0] as $palabra) {
            $minuscula = mb_strtolower($palabra);
            $conteos[$minuscula] = ($conteos[$minuscula] ?? 0) + 1;
        }
    }

    /**
     * @param  array<string, int>  $conteos
     * @return array<string, string>
     */
    public static function construirDiccionario(array $conteos): array
    {
        $formas = [];
        foreach ($conteos as $palabra => $total) {
            $clave = strtr($palabra, self::TILDES);
            if ($clave !== $palabra) {
                $formas[$clave][$palabra] = $total;
            }
        }

        $diccionario = [];
        foreach ($formas as $clave => $acentuadas) {
            if (in_array($clave, self::AMBIGUAS, true)) {
                continue;
            }

            arsort($acentuadas);
            $valores = array_values($acentuadas);
            $mejor = $valores[0];
            $segunda = $valores[1] ?? 0;
            $sinTilde = $conteos[$clave] ?? 0;

            if ($mejor >= 2 * $sinTilde && $segunda * 3 < $mejor) {
                $diccionario[$clave] = array_key_first($acentuadas);
            }
        }

        return $diccionario;
    }

    public function restaurar(?string $texto): ?string
    {
        if ($texto === null || $texto === '') {
            return $texto;
        }

        return preg_replace_callback('/\p{L}+/u', fn ($m) => $this->restaurarPalabra($m[0]), $texto);
    }

    public function restaurarPalabra(string $palabra): string
    {
        // Artefacto de la conversión original: la "í" quedó como "I" mayúscula
        // dentro de palabras en minúsculas (turIstico, ahI, rIo).
        if (mb_strlen($palabra) > 1 && preg_match('/\p{Ll}/u', $palabra)) {
            $palabra = mb_substr($palabra, 0, 1).str_replace('I', 'í', mb_substr($palabra, 1));
        }

        $minuscula = mb_strtolower($palabra);

        if (strtr($minuscula, self::TILDES) !== $minuscula) {
            return $palabra;
        }

        $forma = $this->diccionario[$minuscula] ?? null;

        if ($forma === null && mb_strlen($minuscula) >= 5 && preg_match('/[csx]ion$/u', $minuscula)) {
            $forma = mb_substr($minuscula, 0, -3).'ión';
        }

        if ($forma === null) {
            return $palabra;
        }

        if (mb_strlen($palabra) > 1 && $palabra === mb_strtoupper($palabra)) {
            return mb_strtoupper($forma);
        }

        if (mb_substr($palabra, 0, 1) !== mb_substr($minuscula, 0, 1)) {
            return mb_strtoupper(mb_substr($forma, 0, 1)).mb_substr($forma, 1);
        }

        return $forma;
    }

    /** @return array<string, string> */
    public function diccionario(): array
    {
        return $this->diccionario;
    }
}
