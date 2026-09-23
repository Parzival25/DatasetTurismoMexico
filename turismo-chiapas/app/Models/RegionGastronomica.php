<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RegionGastronomica extends Model
{
    protected $table = 'regiones_gastronomicas';

    protected $fillable = ['slug', 'nombre', 'imagen', 'orden'];

    public function platillos(): HasMany
    {
        return $this->hasMany(Platillo::class)->orderBy('orden');
    }
}
