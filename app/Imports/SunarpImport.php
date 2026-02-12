<?php

namespace App\Imports;

use App\Models\SunarpPartida;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithUpserts;

class SunarpImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithCustomCsvSettings, WithUpserts
{
    public function model(array $row)
    {
        // Mapeo directo de las cabeceras de tu Excel
        return new SunarpPartida([
            'documento'         => $row['documento'],
            'partida_registral' => $row['partida_registral'],
            'zona_registral'    => $row['zona_registral'],
            'oficina'           => $row['oficina'],
        ]);
    }

    /**
     * Evita duplicados basándose en el documento y el número de partida
     */
    public function uniqueBy()
    {
        return ['documento', 'partida_registral'];
    }

    public function getCsvSettings(): array
    {
        return ['delimiter' => ';']; // Usamos punto y coma para tus archivos
    }

    public function batchSize(): int { return 1000; }
    public function chunkSize(): int { return 1000; }
}