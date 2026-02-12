<?php

namespace App\Imports;

use App\Models\Auto;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithUpserts;

class AutosImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithCustomCsvSettings, WithUpserts
{
    public function model(array $row)
    {
        // Validamos que exista al menos el documento y la placa
        if (empty($row['documento']) || empty($row['placa'])) {
            return null;
        }

        return new Auto([
            'documento'         => $row['documento'],
            'placa'             => $row['placa'],
            'nombres_titular'   => $row['nombres'], // Mapeo de columna NOMBRES a nombres_titular
            'clase'             => $row['clase'],
            'compra'            => $row['compra'],
            'fabricacion'       => $row['fabricacion'],
            'marca'             => $row['marca'],
            'nro_transferencia' => $row['nro_transferencia'],
            'tipo_propiedad'    => $row['tipo_propiedad'],
        ]);
    }

    /**
     * Si la placa ya existe para ese documento, actualiza los datos en lugar de duplicar
     */
    public function uniqueBy()
    {
        return ['documento', 'placa'];
    }

    public function getCsvSettings(): array
    {
        return ['delimiter' => ';']; // Punto y coma como separador estándar de tus archivos
    }

    public function batchSize(): int { return 1000; }
    public function chunkSize(): int { return 1000; }
}