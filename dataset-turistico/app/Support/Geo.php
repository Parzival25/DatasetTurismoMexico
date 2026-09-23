<?php

namespace App\Support;

class Geo
{
    private const RADIO_TIERRA_KM = 6371.0;

    /**
     * Distancia en kilómetros entre dos puntos (fórmula de Haversine).
     */
    public static function distanciaKm(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) ** 2 + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) ** 2;

        return self::RADIO_TIERRA_KM * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }

    /**
     * Caja envolvente aproximada alrededor de un punto, para prefiltrar en SQL
     * antes de calcular la distancia exacta.
     *
     * @return array{lat_min: float, lat_max: float, lng_min: float, lng_max: float}
     */
    public static function caja(float $lat, float $lng, float $radioKm): array
    {
        $dLat = rad2deg($radioKm / self::RADIO_TIERRA_KM);
        $dLng = rad2deg($radioKm / self::RADIO_TIERRA_KM / max(cos(deg2rad($lat)), 0.01));

        return [
            'lat_min' => $lat - $dLat,
            'lat_max' => $lat + $dLat,
            'lng_min' => $lng - $dLng,
            'lng_max' => $lng + $dLng,
        ];
    }

    public static function dentroDeChiapas(?float $lat, ?float $lng): bool
    {
        if ($lat === null || $lng === null) {
            return false;
        }

        $l = config('dataset.limites');

        return $lat >= $l['lat_min'] && $lat <= $l['lat_max']
            && $lng >= $l['lng_min'] && $lng <= $l['lng_max'];
    }
}
