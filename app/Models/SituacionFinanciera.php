<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SituacionFinanciera extends Model
{
    protected $table = 'sbs_resumen';
    protected $primaryKey = 'id';
    public $timestamps = false;

    // Relación simple por documento
    public function detalles()
    {
        return $this->hasMany(SituacionDetalle::class, 'documento', 'documento');
    }
}