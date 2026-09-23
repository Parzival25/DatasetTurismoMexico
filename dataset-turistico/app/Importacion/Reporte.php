<?php

namespace App\Importacion;

use Illuminate\Support\Facades\Storage;

/**
 * Bitácora de la importación: todo lo que se corrigió automáticamente o que
 * necesita revisión humana.
 */
class Reporte
{
    /** @var list<array{nivel: string, tipo: string, id: int|string|null, nombre: string, mensaje: string}> */
    private array $entradas = [];

    /** @var array<string, int> */
    private array $contadores = [];

    public function info(string $tipo, int|string|null $id, string $nombre, string $mensaje): void
    {
        $this->agregar('corregido', $tipo, $id, $nombre, $mensaje);
    }

    public function aviso(string $tipo, int|string|null $id, string $nombre, string $mensaje): void
    {
        $this->agregar('revisar', $tipo, $id, $nombre, $mensaje);
    }

    public function sumar(string $contador, int $cantidad = 1): void
    {
        $this->contadores[$contador] = ($this->contadores[$contador] ?? 0) + $cantidad;
    }

    public function contador(string $contador): int
    {
        return $this->contadores[$contador] ?? 0;
    }

    public function entradas(): array
    {
        return $this->entradas;
    }

    public function porRevisar(): int
    {
        return count(array_filter($this->entradas, fn ($e) => $e['nivel'] === 'revisar'));
    }

    public function guardar(): string
    {
        $disco = Storage::disk('reportes');

        $csv = fopen('php://temp', 'w+');
        fwrite($csv, "\xEF\xBB\xBF");
        fputcsv($csv, ['nivel', 'tipo', 'id', 'nombre', 'mensaje']);
        foreach ($this->entradas as $entrada) {
            fputcsv($csv, array_values($entrada));
        }
        rewind($csv);
        $disco->put('importacion.csv', stream_get_contents($csv));
        fclose($csv);

        $disco->put('importacion.json', json_encode([
            'fecha' => now()->toIso8601String(),
            'contadores' => $this->contadores,
            'por_revisar' => $this->porRevisar(),
            'corregidos' => count($this->entradas) - $this->porRevisar(),
            'entradas' => $this->entradas,
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        return $disco->path('importacion.csv');
    }

    private function agregar(string $nivel, string $tipo, int|string|null $id, string $nombre, string $mensaje): void
    {
        $this->entradas[] = compact('nivel', 'tipo', 'id', 'nombre', 'mensaje');
    }
}
