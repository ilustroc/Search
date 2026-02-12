<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Correo extends Model
{
    protected $table = 'correos';
    public $timestamps = false;

    // Campos permitidos para la carga masiva
    protected $fillable = [
        'documento',
        'correo'
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'documento', 'documento');
    }
}