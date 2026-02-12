<?php

namespace App\Imports;

use App\Models\Sueldo;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithUpserts; // <--- AGREGAR ESTO
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class SueldosImport implements ToModel, WithHeadingRow, WithBatchInserts, WithUpserts, WithCustomCsvSettings
{
    public function model(array $row)
    {
        if (empty($row['documento']) || empty($row['fecha'])) {
            return null;
        }

        return new Sueldo([
            'documento' => $row['documento'],
            'periodo'   => $row['fecha'],
            'ruc'       => $row['ruc'],
            'sueldo'    => (float) $row['sueldo'],
            'situacion' => $row['situacion'],
        ]);
    }

    /**
     * Define qué combinación de campos identifica un registro único.
     * Esto coincide con tu llave 'uk_doc_periodo_ruc'
     */
    public function uniqueBy()
    {
        return ['documento', 'periodo', 'ruc'];
    }

    public function getCsvSettings(): array
    {
        return ['delimiter' => ';'];
    }

    public function batchSize(): int { return 1000; }
}