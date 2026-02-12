<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SbsResumen extends Model
{
    protected $table = 'sbs_resumen';
    public $timestamps = false;

    protected $fillable = [
        'documento', 'cod_sbs', 'cantidad_empresas',
        'calificacion_normal', 'calificacion_cpp', 
        'calificacion_deficiente', 'calificacion_dudoso', 'calificacion_perdida'
    ];
}