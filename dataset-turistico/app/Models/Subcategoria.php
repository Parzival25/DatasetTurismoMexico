<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Clasificación C2: tipo de atractivo dentro de una categoría C1.
 */
class Subcategoria extends Model
{
    protected $table = 'subcategorias';

    public $incrementing = false;

    protected $fillable = ['id', 'categoria_id', 'slug', 'nombre'];

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where(ctype_digit((string) $value) ? 'id' : 'slug', $value)->firstOrFail();
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function atomos(): BelongsToMany
    {
        return $this->belongsToMany(Atomo::class, 'atomo_subcategoria');
    }

    public function eventos(): BelongsToMany
    {
        return $this->belongsToMany(Evento::class, 'evento_subcategoria');
    }
}
