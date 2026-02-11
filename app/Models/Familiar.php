<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Familiar extends Model
{
    protected $table = 'familiares';
    public $timestamps = false;

    protected $casts = [
        'f_nac_fam' => 'date'
    ];

    // Compatibilidad con tu lógica de Python: fecha_nac_fam
    public function getFechaNacFamAttribute()
    {
        return $this->f_nac_fam ? $this->f_nac_fam->format('Y-m-d') : '';
    }
}