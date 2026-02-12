<?php

namespace App\Imports;

use App\Models\Direccion;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithUpserts;

class DireccionesImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithCustomCsvSettings, WithUpserts
{
    public function model(array $row)
    {
        return new Direccion([
            'documento'         => $row['documento'],
            'direccion'         => $row['direccion'],
            'departamento'      => $row['departamento'],
            'provincia'         => $row['provincia'],
            'distrito'          => $row['distrito'],
            'ubigeo_nacimiento' => $row['ubigeo_nacimiento'] ?? null,
        ]);
    }

    // Si el DNI ya tiene esa dirección exacta, la actualiza en lugar de duplicarla
    public function uniqueBy()
    {
        return ['documento', 'direccion'];
    }

    public function getCsvSettings(): array
    {
        return ['delimiter' => ';'];
    }

    public function batchSize(): int { return 1000; }
    public function chunkSize(): int { return 1000; }
}