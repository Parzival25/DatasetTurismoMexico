<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Proyecto Mexmapa del que se extrajo la información (región o municipio).
 */
class Origen extends Model
{
    protected $table = 'origenes';

    public $incrementing = false;

    protected $fillable = ['id', 'slug', 'nombre', 'descripcion', 'carpeta_legado'];

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where(ctype_digit((string) $value) ? 'id' : 'slug', $value)->firstOrFail();
    }

    public function atomos(): HasMany
    {
        return $this->hasMany(Atomo::class);
    }
}
