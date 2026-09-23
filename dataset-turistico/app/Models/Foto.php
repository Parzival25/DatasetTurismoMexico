<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

class Foto extends Model
{
    protected $table = 'fotos';

    protected $fillable = [
        'propietario_type', 'propietario_id', 'ruta', 'ruta_miniatura', 'mime',
        'ancho', 'alto', 'bytes', 'orden', 'credito', 'archivo_original',
    ];

    protected static function booted(): void
    {
        static::deleted(function (Foto $foto) {
            Storage::disk('fotos')->delete(array_filter([$foto->ruta, $foto->ruta_miniatura]));
        });
    }

    public function propietario(): MorphTo
    {
        return $this->morphTo();
    }

    public function url(): string
    {
        return route('fotos.mostrar', $this);
    }

    public function urlMiniatura(): string
    {
        return $this->ruta_miniatura ? route('fotos.miniatura', $this) : $this->url();
    }
}
