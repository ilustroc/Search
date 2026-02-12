<?php

namespace App\Imports;

use App\Models\Telefono;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class TelefonosImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    public function model(array $row)
    {
        return new Telefono([
            'documento'      => $row['documento'],
            'telefono'       => $row['telefono'],
            'tipo'           => $row['tipo'],
            'origen'         => $row['origen'],
            'fecha_act_raw'  => $row['fecha_act'],
        ]);
    }

    public function batchSize(): int { return 1000; }
    public function chunkSize(): int { return 1000; }
}