<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sueldo extends Model
{
    // Nombre exacto de tu tabla física
    protected $table = 'sueldos';
    public $timestamps = false;

    // Atributos autorizados para carga masiva
    protected $fillable = [
        'documento',
        'periodo', // Mapearemos 'FECHA' del CSV a esta columna
        'ruc',
        'sueldo',
        'situacion'
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'documento', 'documento');
    }
}