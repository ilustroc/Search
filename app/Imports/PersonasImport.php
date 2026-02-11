<?php
namespace App\Imports;

use App\Models\Persona;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts; // Crucial para velocidad
use Maatwebsite\Excel\Concerns\WithUpserts;      // Maneja duplicados sin fallar
use Maatwebsite\Excel\Concerns\WithChunkReading;

class PersonasImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithUpserts
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

    /**
     * Define qué columna es la clave única (DNI). 
     * Si el DNI ya existe, lo actualiza en lugar de dar error.
     */
    public function uniqueBy()
    {
        return 'documento';
    }

    /** Inserta en bloques de 1,000 registros por cada consulta SQL. */
    public function batchSize(): int
    {
        return 1000;
    }

    /** Lee el archivo en trozos de 1,000 para no saturar la memoria RAM. */
    public function chunkSize(): int
    {
        return 1000;
    }
}