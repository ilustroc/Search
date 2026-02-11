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
        'fecha_activacion' => 'date'
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'documento', 'documento');
    }
}