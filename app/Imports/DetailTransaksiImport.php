<?php

namespace App\Imports;

use App\Models\Pembelian;
use Maatwebsite\Excel\Concerns\ToModel;

class DetailTransaksiImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $UNIX_DATE = ($row[8] - 25569) * 86400;
        return new Pembelian([
            'kodetransaksi' => str_replace(' ','',$row[0]),
            'totalbayar' => $row[5],
            'tanggaltransaksi' => gmdate("Y-m-d", ($row[8] - 25569) * 86400),
            'kodeproduk' => $row[2],
            'jumlahproduk' => $row[3],
        ]);
    }
}
