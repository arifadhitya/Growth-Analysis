<?php

namespace App\Imports;

use App\Models\Pembelian;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class DetailTransaksiImport implements ToModel, WithChunkReading, WithBatchInserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $UNIX_DATE = ($row[4] - 25569) * 86400;
        return new Pembelian([
            'kodetransaksi' => str_replace(' ','',$row[0]),
            'totalbayar' => $row[3],
            'tanggaltransaksi' => gmdate("Y-m-d", ($row[4] - 25569) * 86400),
            'kodeproduk' => $row[1],
            'jumlahproduk' => $row[2],
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
