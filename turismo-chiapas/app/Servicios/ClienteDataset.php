<?php

namespace App\Servicios;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Cliente de la API pública del Dataset Turístico de Chiapas.
 *
 * Cada respuesta se guarda dos veces: una copia "fresca" que vence a los
 * pocos minutos y una copia de respaldo sin vencimiento. Si la API no
 * responde, se usa el respaldo para que el sitio siga funcionando.
 */
class ClienteDataset
{
    public function __construct(
        private string $url,
        private int $timeout,
        private int $cacheMinutos,
    ) {
    }

    public static function desdeConfiguracion(): self
    {
        return new self(config('turismo.api_url'), config('turismo.timeout'), config('turismo.cache_minutos'));
    }

    public function indice(): array
    {
        return $this->obtener('') ?? [];
    }

    /**
     * Devuelve null si la API rechaza los filtros (por ejemplo, una categoría inexistente).
     *
     * @param  array<string, mixed>  $filtros
     * @return array{datos: list<array>, meta: array, enlaces: array}|null
     */
    public function atomos(array $filtros = []): ?array
    {
        return $this->obtener('atomos', $filtros);
    }

    public function atomo(string $idOSlug): ?array
    {
        return $this->obtener('atomos/'.rawurlencode($idOSlug), [], true)['datos'] ?? null;
    }

    public function cercanos(int $id, int $limite = 6, float $radio = 40): array
    {
        return $this->obtener("atomos/{$id}/cercanos", ['limite' => $limite, 'radio' => $radio])['datos'] ?? [];
    }

    public function mapa(array $filtros = []): ?array
    {
        return $this->obtener('mapa', $filtros);
    }

    public function categorias(): array
    {
        return $this->obtener('categorias')['datos'] ?? [];
    }

    public function origenes(): array
    {
        return $this->obtener('origenes')['datos'] ?? [];
    }

    public function origen(string $slug): ?array
    {
        return $this->obtener('origenes/'.rawurlencode($slug), [], true)['datos'] ?? null;
    }

    public function eventos(array $filtros = []): array
    {
        return $this->obtener('eventos', $filtros)['datos'] ?? [];
    }

    public function evento(string $idOSlug): ?array
    {
        return $this->obtener('eventos/'.rawurlencode($idOSlug), [], true)['datos'] ?? null;
    }

    /**
     * @throws DatasetNoDisponible
     */
    private function obtener(string $ruta, array $parametros = [], bool $permitir404 = false): ?array
    {
        $parametros = array_filter($parametros, fn ($v) => $v !== null && $v !== '');
        ksort($parametros);
        $clave = 'dataset:'.md5($ruta.'?'.http_build_query($parametros));

        if (($fresca = Cache::get($clave)) !== null) {
            return $fresca['respuesta'];
        }

        try {
            $respuesta = Http::acceptJson()
                ->timeout($this->timeout)
                ->connectTimeout(min(3, $this->timeout))
                ->get($this->url.($ruta === '' ? '' : '/'.$ruta), $parametros);

            if ($permitir404 && $respuesta->status() === 404) {
                Cache::put($clave, ['respuesta' => null], now()->addMinutes($this->cacheMinutos));

                return null;
            }

            $respuesta->throw();
            $datos = $respuesta->json();

            Cache::put($clave, ['respuesta' => $datos], now()->addMinutes($this->cacheMinutos));
            Cache::forever("{$clave}:respaldo", $datos);

            return $datos;
        } catch (ConnectionException|RequestException $e) {
            if ($e instanceof RequestException && $e->response->status() === 422) {
                return null;
            }

            $respaldo = Cache::get("{$clave}:respaldo");
            Log::warning('No se pudo consultar la API del dataset', ['ruta' => $ruta, 'error' => $e->getMessage(), 'usa_respaldo' => $respaldo !== null]);

            if ($respaldo !== null) {
                return $respaldo;
            }

            throw new DatasetNoDisponible('La API del dataset no está disponible.', previous: $e);
        }
    }
}
