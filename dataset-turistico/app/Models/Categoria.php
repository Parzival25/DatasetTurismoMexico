<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Clasificación C1: uno de los siete grupos de actividad.
 */
class Categoria extends Model
{
    protected $table = 'categorias';

    public $incrementing = false;

    protected $fillable = ['id', 'slug', 'nombre', 'descripcion', 'color', 'icono', 'orden'];

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where(ctype_digit((string) $value) ? 'id' : 'slug', $value)->firstOrFail();
    }

    public function subcategorias(): HasMany
    {
        return $this->hasMany(Subcategoria::class)->orderBy('nombre');
    }

    public function atomos(): BelongsToMany
    {
        return $this->belongsToMany(Atomo::class, 'atomo_categoria');
    }
}
