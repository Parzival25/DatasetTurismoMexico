<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Actividad extends Model
{
    protected $table = 'actividades';

    protected $fillable = ['atomo_id', 'descripcion', 'orden'];

    public function atomo(): BelongsTo
    {
        return $this->belongsTo(Atomo::class);
    }
}
