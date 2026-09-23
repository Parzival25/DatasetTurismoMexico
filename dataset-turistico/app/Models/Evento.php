<?php

namespace App\Models;

use App\Support\Texto;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Átomo temporal: feria, festival o fiesta que ocurre en una fecha del año.
 */
class Evento extends Model
{
    protected $table = 'eventos';

    protected $fillable = [
        'id', 'slug', 'nombre', 'descripcion', 'localizacion', 'como_llegar', 'actividades',
        'latitud', 'longitud', 'fecha', 'periodo', 'recurrente', 'activo',
    ];

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
            'recurrente' => 'boolean',
            'latitud' => 'float',
            'longitud' => 'float',
            'fecha' => 'immutable_date',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Evento $evento) {
            $evento->busqueda = Texto::normalizar(implode(' ', [
                $evento->nombre, $evento->localizacion, $evento->descripcion,
            ]));
        });
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where(ctype_digit((string) $value) ? 'id' : 'slug', $value)->firstOrFail();
    }

    public function subcategorias(): BelongsToMany
    {
        return $this->belongsToMany(Subcategoria::class, 'evento_subcategoria')->orderBy('subcategorias.id');
    }

    public function fotos(): MorphMany
    {
        return $this->morphMany(Foto::class, 'propietario')->orderBy('orden')->orderBy('id');
    }

    public function scopeActivos(Builder $query): Builder
    {
        return $query->where('activo', true);
    }

    /**
     * Siguiente fecha en que ocurre el evento. Los eventos recurrentes se
     * repiten cada año en el mismo día y mes que la fecha registrada.
     */
    public function proximaFecha(?CarbonImmutable $hoy = null): ?CarbonImmutable
    {
        if (! $this->fecha) {
            return null;
        }

        if (! $this->recurrente) {
            return $this->fecha;
        }

        $hoy = ($hoy ?? CarbonImmutable::today())->startOfDay();
        $candidata = $this->fecha->setYear($hoy->year);

        return $candidata->lessThan($hoy) ? $candidata->addYear() : $candidata;
    }
}
