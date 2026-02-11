<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SituacionDetalle extends Model
{
    protected $table = 'sbs_detalle';
    public $timestamps = false;

    // Para manejar los montos decimales correctamente
    protected $casts = [
        'monto' => 'decimal:2'
    ];
}