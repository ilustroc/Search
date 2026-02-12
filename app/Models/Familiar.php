<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Familiar extends Model
{
    protected $table = 'familiares';
    public $timestamps = false;

    // Campos autorizados para carga masiva
    protected $fillable = [
        'documento',
        'documento_fam',
        'paterno_fam',
        'materno_fam',
        'nombre_fam',
        'f_nac_fam',
        'tipo_fam'
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'documento', 'documento');
    }
}