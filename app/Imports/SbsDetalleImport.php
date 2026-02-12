<?php

namespace App\Imports;

use App\Models\SbsDetalle;
use Maatwebsite\Excel\Concerns\{ToModel, WithHeadingRow, WithBatchInserts, WithCustomCsvSettings};

class SbsDetalleImport implements ToModel, WithHeadingRow, WithBatchInserts, WithCustomCsvSettings
{
    public function model(array $row)
    {
        return new SbsDetalle([
            'fecha_reporte_sbs' => $row['fecha_reporte_sbs'],
            'documento'         => $row['documento'],
            'cod_sbs'           => $row['cod_sbs'],
            'entidad'           => $row['entidad'],
            'monto'             => $row['monto'],
            'dias_atraso'       => $row['dias_atraso'],
        ]);
    }

    public function getCsvSettings(): array { return ['delimiter' => ';']; }
    public function batchSize(): int { return 1000; }
}