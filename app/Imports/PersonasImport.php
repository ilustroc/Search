<?php

namespace App\Imports;

use App\Models\Persona;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class PersonasImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
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

    // Inserta en bloques de 1000 registros (Súper rápido)
    public function batchSize(): int
    {
        return 1000;
    }

    // Lee el archivo en trozos para no agotar la memoria
    public function chunkSize(): int
    {
        return 1000;
    }
}