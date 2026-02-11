<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SituacionFinanciera extends Model
{
    protected $table = 'sbs_resumen';
    
    // IMPORTANTE: Laravel 12 usa timestamps por defecto, tu SQL los tiene
    // pero si dan problemas puedes poner public $timestamps = false;
    
    public function detalles()
    {
        // Especificamos las llaves locales y foráneas exactas de tu SQL
        return $this->hasMany(SituacionDetalle::class, 'documento', 'documento')
                    ->whereColumn('sbs_detalle.cod_sbs', 'sbs_resumen.cod_sbs');
    }

    public function getFechaReporteAttribute()
    {
        // En tu SQL fecha_reporte_sbs es CHAR(6) en sbs_detalle
        return $this->detalles()->max('fecha_reporte_sbs') ?? '---';
    }
}