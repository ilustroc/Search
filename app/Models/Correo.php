<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Correo extends Model
{
    protected $table = 'correos';
    public $timestamps = false;

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'documento', 'documento');
    }
}