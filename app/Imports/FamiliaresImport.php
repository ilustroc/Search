<?php

namespace App\Imports;

use App\Models\Familiar;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class FamiliaresImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithCustomCsvSettings
{
    public function model(array $row)
    {
        // Validación básica para evitar filas vacías
        if (empty($row['documento']) || empty($row['nombre_fam'])) {
            return null;
        }

        return new Familiar([
            'documento'     => $row['documento'],
            'documento_fam' => $row['documento_fam'],
            'paterno_fam'   => $row['paterno_fam'],
            'materno_fam'   => $row['materno_fam'],
            'nombre_fam'    => $row['nombre_fam'],
            'f_nac_fam'     => $this->transformDate($row['f_nac_fam']),
            'tipo_fam'      => $row['tipo_fam'],
        ]);
    }

    /**
     * Limpia fechas inválidas como '1900-01-00' antes de insertar
     */
    private function transformDate($value)
    {
        if (empty($value) || $value == '1900-01-00') {
            return null;
        }
        return $value;
    }

    public function getCsvSettings(): array
    {
        return ['delimiter' => ';']; // Punto y coma como en tus otros archivos
    }

    public function batchSize(): int { return 1000; }
    public function chunkSize(): int { return 1000; }
}