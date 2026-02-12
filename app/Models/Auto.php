<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auto extends Model
{
    protected $table = 'autos';
    public $timestamps = false;

    // Campos autorizados para la carga masiva basados en tu DB
    protected $fillable = [
        'documento',
        'placa',
        'nombres_titular', // Se mapea desde la columna NOMBRES del Excel
        'clase',
        'compra',
        'fabricacion',
        'marca',
        'nro_transferencia',
        'tipo_propiedad'
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'documento', 'documento');
    }
}