<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Platillo extends Model
{
    protected $table = 'platillos';

    protected $fillable = ['region_gastronomica_id', 'nombre', 'imagen', 'orden'];

    public function region(): BelongsTo
    {
        return $this->belongsTo(RegionGastronomica::class, 'region_gastronomica_id');
    }
}
