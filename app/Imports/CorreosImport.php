<?php

namespace App\Imports;

use App\Models\Correo;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithUpserts;

class CorreosImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithCustomCsvSettings, WithUpserts
{
    public function model(array $row)
    {
        // Validamos que el campo 'correo' no venga vacío en el CSV
        if (empty($row['correo'])) {
            return null;
        }

        return new Correo([
            'documento' => $row['documento'],
            'correo'    => strtolower(trim($row['correo'])), // Normalizamos a minúsculas
        ]);
    }

    /**
     * Evita duplicados: si el DNI ya tiene ese correo, lo ignora o actualiza
     */
    public function uniqueBy()
    {
        return ['documento', 'correo'];
    }

    /**
     * Configuración para tus archivos CSV con punto y coma (;)
     */
    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ','
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}