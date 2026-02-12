<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Telefono extends Model
{
    protected $table = 'telefonos';
    public $timestamps = false;

    // Casteamos el campo yape a booleano automáticamente
    protected $casts = [
        'yape' => 'boolean',
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'documento', 'documento');
    }
    
    // Lista de campos que permitimos llenar masivamente
    protected $fillable = [
        'documento', 
        'telefono', 
        'tipo', 
        'origen', 
        'fecha_act_raw'
    ];
}