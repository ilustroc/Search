<?php

namespace App\Imports;

use App\Models\SbsResumen;
use Maatwebsite\Excel\Concerns\{ToModel, WithHeadingRow, WithBatchInserts, WithUpserts, WithCustomCsvSettings};

class SbsResumenImport implements ToModel, WithHeadingRow, WithBatchInserts, WithUpserts, WithCustomCsvSettings
{
    public function model(array $row)
    {
        return new SbsResumen([
            'documento'               => $row['documento'],
            'cod_sbs'                 => $row['cod_sbs'],
            'cantidad_empresas'       => $row['cantidad_empresas'],
            'calificacion_normal'     => $row['calificacion_normal'],
            'calificacion_cpp'        => $row['calificacion_cpp'],
            'calificacion_deficiente' => $row['calificacion_deficiente'],
            'calificacion_dudoso'     => $row['calificacion_dudoso'],
            'calificacion_perdida'    => $row['calificacion_perdida'],
        ]);
    }

    public function uniqueBy() { return 'documento'; }
    public function getCsvSettings(): array { return ['delimiter' => ';']; }
    public function batchSize(): int { return 1000; }
}