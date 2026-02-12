<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SunarpPartida extends Model
{
    protected $table = 'sunarp_partidas';
    
    public $timestamps = false;

    protected $fillable = [
        'documento',
        'partida_registral',
        'zona_registral',
        'oficina'
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'documento', 'documento');
    }
}