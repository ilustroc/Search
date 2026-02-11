<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas';
    protected $primaryKey = 'documento'; // Tu PRIMARY KEY es documento
    public $incrementing = false;        // No es auto-increment
    protected $keyType = 'string';
    protected $fillable = [
    'documento', 'paterno', 'materno', 'nombres', 
    'nacimiento', 'sexo', 'estado_civil', 'padre', 
    'madre', 'direccion_raw'
    ];
    
    // Relaciones basadas en tu SQL
    public function direcciones() { return $this->hasMany(Direccion::class, 'documento', 'documento'); }
    public function telefonos() { return $this->hasMany(Telefono::class, 'documento', 'documento'); }
    public function correos() { return $this->hasMany(Correo::class, 'documento', 'documento'); }
    public function familiares() { return $this->hasMany(Familiar::class, 'documento', 'documento'); }
    public function autos() { return $this->hasMany(Auto::class, 'documento', 'documento'); }
    public function propiedades() { return $this->hasMany(SunarpPartida::class, 'documento', 'documento'); }
    public function situaciones() { return $this->hasMany(SituacionFinanciera::class, 'documento', 'documento'); }

    // Accessor para nombre completo
    public function getNombreCompletoAttribute() {
        return trim("{$this->nombres} {$this->paterno} {$this->materno}");
    }
}