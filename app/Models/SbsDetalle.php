<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SbsDetalle extends Model
{
    protected $table = 'sbs_detalle';
    public $timestamps = false;

    protected $fillable = [
        'fecha_reporte_sbs', 'documento', 'cod_sbs', 
        'entidad', 'monto', 'dias_atraso'
    ];
}