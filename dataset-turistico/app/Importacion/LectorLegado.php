<?php

namespace App\Importacion;

use DOMDocument;
use DOMXPath;
use App\Support\Texto;

/**
 * Lectura de los archivos del Prototipo 1: HTML y SQL con codificaciones
 * mezcladas (UTF-8 con y sin BOM, Windows-1252).
 */
class LectorLegado
{
    public static function leerTexto(string $ruta): string
    {
        $contenido = (string) @file_get_contents($ruta);
        $contenido = preg_replace('/^\xEF\xBB\xBF/', '', $contenido);

        if (! mb_check_encoding($contenido, 'UTF-8')) {
            $contenido = mb_convert_encoding($contenido, 'UTF-8', 'Windows-1252');
        }

        return $contenido;
    }

    /**
     * Convierte HTML a texto plano (sin scripts, estilos ni entidades).
     */
    public static function htmlATexto(string $html): string
    {
        $html = preg_replace('#<(script|style)\b.*?</\1>#is', ' ', $html);
        $html = preg_replace('#<br\s*/?>|</p>|</li>|</div>#i', "\n", $html);

        return html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /**
     * Lee una ficha HTML de átomo. Todas las plantillas de los subproyectos
     * comparten un #titulo y cuatro pestañas en este orden: descripción,
     * localización, cómo llegar y actividades.
     *
     * @return array{titulo: string, secciones: list<string>, imagenes: list<string>}|null
     */
    public static function leerFicha(string $ruta): ?array
    {
        if (! is_file($ruta)) {
            return null;
        }

        $dom = new DOMDocument;
        @$dom->loadHTML('<?xml encoding="UTF-8">'.self::leerTexto($ruta), LIBXML_NOERROR | LIBXML_NOWARNING);
        $xpath = new DOMXPath($dom);

        $titulo = $xpath->query('//*[@id="titulo"]')->item(0)?->textContent ?? '';

        $secciones = [];
        foreach (['tab_content', 'content'] as $clase) {
            $nodos = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' {$clase} ')]");
            foreach ($nodos as $nodo) {
                $secciones[] = Texto::limpiar($nodo->textContent);
            }
            if ($secciones) {
                break;
            }
        }

        $imagenes = [];
        foreach ($xpath->query('//img/@src') as $src) {
            $valor = trim($src->nodeValue);
            if (preg_match('/\.(jpe?g|png|gif|bmp|webp)$/i', $valor) && ! in_array($valor, $imagenes, true)) {
                $imagenes[] = $valor;
            }
        }

        return [
            'titulo' => Texto::limpiar($titulo),
            'secciones' => $secciones,
            'imagenes' => $imagenes,
        ];
    }

    /**
     * Extrae las filas de los INSERT de una tabla en un volcado de phpMyAdmin.
     *
     * @return list<array<string, string|null>>
     */
    public static function leerInsertsSql(string $sql, string $tabla): array
    {
        $filas = [];
        $patron = '/INSERT INTO `'.preg_quote($tabla, '/').'`\s*\(([^)]*)\)\s*VALUES\s*/i';

        preg_match_all($patron, $sql, $coincidencias, PREG_OFFSET_CAPTURE);

        foreach ($coincidencias[0] as $i => [$texto, $posicion]) {
            $columnas = array_map(fn ($c) => trim($c, " `\t\n\r"), explode(',', $coincidencias[1][$i][0]));
            $pos = $posicion + strlen($texto);

            foreach (self::leerTuplas($sql, $pos) as $valores) {
                if (count($valores) === count($columnas)) {
                    $filas[] = array_combine($columnas, $valores);
                }
            }
        }

        return $filas;
    }

    /**
     * @return list<list<string|null>>
     */
    private static function leerTuplas(string $sql, int $pos): array
    {
        $tuplas = [];
        $largo = strlen($sql);

        while ($pos < $largo) {
            $c = $sql[$pos];

            if ($c === ';') {
                break;
            }

            if ($c !== '(') {
                $pos++;
                continue;
            }

            $pos++;
            $valores = [];

            while ($pos < $largo) {
                while ($pos < $largo && ctype_space($sql[$pos])) {
                    $pos++;
                }

                if ($sql[$pos] === "'") {
                    $pos++;
                    $valor = '';
                    while ($pos < $largo) {
                        $c = $sql[$pos];
                        if ($c === '\\' && $pos + 1 < $largo) {
                            $siguiente = $sql[$pos + 1];
                            $valor .= match ($siguiente) {
                                'n' => "\n", 'r' => "\r", 't' => "\t", '0' => "\0",
                                default => $siguiente,
                            };
                            $pos += 2;
                            continue;
                        }
                        if ($c === "'" && ($sql[$pos + 1] ?? '') === "'") {
                            $valor .= "'";
                            $pos += 2;
                            continue;
                        }
                        if ($c === "'") {
                            $pos++;
                            break;
                        }
                        $valor .= $c;
                        $pos++;
                    }
                    $valores[] = $valor;
                } else {
                    $inicio = $pos;
                    while ($pos < $largo && $sql[$pos] !== ',' && $sql[$pos] !== ')') {
                        $pos++;
                    }
                    $crudo = trim(substr($sql, $inicio, $pos - $inicio));
                    $valores[] = strtoupper($crudo) === 'NULL' ? null : $crudo;
                }

                while ($pos < $largo && ctype_space($sql[$pos])) {
                    $pos++;
                }

                if (($sql[$pos] ?? '') === ',') {
                    $pos++;
                    continue;
                }

                if (($sql[$pos] ?? '') === ')') {
                    $pos++;
                    break;
                }
            }

            $tuplas[] = $valores;
        }

        return $tuplas;
    }
}
