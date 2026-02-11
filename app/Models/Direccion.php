<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    protected $table = 'direcciones';
    public $timestamps = false;

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'documento', 'documento');
    }
}