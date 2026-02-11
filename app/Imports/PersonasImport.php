<?php

namespace App\Imports;

use App\Models\Persona;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation; // Añadido
use Maatwebsite\Excel\Concerns\SkipsOnFailure; // Añadido
use Maatwebsite\Excel\Concerns\SkipsFailures;  // Añadido

class PersonasImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    public function model(array $row)
    {
        return new Persona([
            'documento'     => $row['documento'],
            'paterno'       => $row['paterno'],
            'materno'       => $row['materno'],
            'nombres'       => $row['nombres'],
            'nacimiento'    => $row['nacimiento'],
            'direccion_raw' => $row['direccion'],
            'sexo'          => $row['sexo'],
            'estado_civil'  => $row['estado_civil'],
            'padre'         => $row['padre'],
            'madre'         => $row['madre'],
        ]);
    }

    // Reglas de validación por cada fila del Excel
    public function rules(): array
    {
        return [
            'documento' => 'required|digits:8|unique:personas,documento',
            'nombres'   => 'required|string',
            'nacimiento'=> 'required|date_format:Y-m-d', // Valida el formato de tu Excel
        ];
    }
}