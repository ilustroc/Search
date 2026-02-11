<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SituacionFinanciera extends Model
{
    protected $table = 'sbs_resumen';
    public $timestamps = false;

    public function detalles()
    {
        return $this->hasMany(SituacionDetalle::class, 'documento', 'documento')
                    ->whereColumn('cod_sbs', 'sbs_resumen.cod_sbs');
    }

    public function getFechaReporteAttribute()
    {
        return $this->detalles()->max('fecha_reporte_sbs') ?? '';
    }
}