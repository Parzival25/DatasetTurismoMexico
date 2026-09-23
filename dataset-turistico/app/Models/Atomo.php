<?php

namespace App\Models;

use App\Support\Texto;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Átomo turístico: un lugar concreto al que las personas llegan para conocer
 * y realizar actividades de esparcimiento (definición de la tesis).
 */
class Atomo extends Model
{
    protected $table = 'atomos';

    protected $fillable = [
        'id', 'slug', 'nombre', 'descripcion', 'localizacion', 'como_llegar',
        'latitud', 'longitud', 'activo', 'origen_id', 'numero_original', 'legado_activo',
    ];

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
            'latitud' => 'float',
            'longitud' => 'float',
            'numero_original' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Atomo $atomo) {
            $atomo->busqueda = Texto::normalizar(implode(' ', [
                $atomo->nombre, $atomo->localizacion, $atomo->descripcion,
            ]));
        });
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where(ctype_digit((string) $value) ? 'id' : 'slug', $value)->firstOrFail();
    }

    public function origen(): BelongsTo
    {
        return $this->belongsTo(Origen::class);
    }

    public function categorias(): BelongsToMany
    {
        return $this->belongsToMany(Categoria::class, 'atomo_categoria')->orderBy('categorias.orden');
    }

    public function subcategorias(): BelongsToMany
    {
        return $this->belongsToMany(Subcategoria::class, 'atomo_subcategoria')->orderBy('subcategorias.id');
    }

    public function actividades(): HasMany
    {
        return $this->hasMany(Actividad::class)->orderBy('orden');
    }

    public function fotos(): MorphMany
    {
        return $this->morphMany(Foto::class, 'propietario')->orderBy('orden')->orderBy('id');
    }

    public function scopeActivos(Builder $query): Builder
    {
        return $query->where('activo', true);
    }

    public function tieneCoordenadas(): bool
    {
        return $this->latitud !== null && $this->longitud !== null;
    }
}
