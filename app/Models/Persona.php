<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Persona extends Model
{
    protected $table = 'personas';
    protected $primaryKey = 'documento';
    public $incrementing = false; // Porque el DNI no es autoincremental
    protected $keyType = 'string';
    public $timestamps = false; // Si tu tabla no tiene created_at/updated_at

    // Relaciones
    public function direcciones() { return $this->hasMany(Direccion::class, 'documento', 'documento'); }
    public function telefonos() { return $this->hasMany(Telefono::class, 'documento', 'documento'); }
    public function correos() { return $this->hasMany(Correo::class, 'documento', 'documento'); }
    public function familiares() { return $this->hasMany(Familiar::class, 'documento', 'documento'); }
    public function autos() { return $this->hasMany(Auto::class, 'documento', 'documento'); }
    public function propiedades() { return $this->hasMany(SunarpPartida::class, 'documento', 'documento'); }
    public function situaciones() { return $this->hasMany(SituacionFinanciera::class, 'documento', 'documento'); }

    // Accessors (Como los @property de Python)
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombres} {$this->paterno} {$this->materno}";
    }

    public function getEdadAttribute()
    {
        return $this->nacimiento ? Carbon::parse($this->nacimiento)->age : 'Desconocida';
    }
}