<?php

namespace App\Imports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;


class TransaksiImport implements ToModel, WithChunkReading, WithBatchInserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $UNIX_DATE = ($row[0] - 25569) * 86400;
        return  new Transaksi([
            'kodetransaksi' => str_replace(' ','',$row[1]),
            'totalbayar' => $row[2],
            'operator' => $row[3],
            'tanggaljual' => gmdate("Y-m-d", ($row[0] - 25569) * 86400),
        ]);
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
