<?php

namespace App\Imports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\ToModel;


class TransaksiImport implements ToModel
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
            'totalbayar' => $row[3],
            'operator' => $row[12],
            'tanggaljual' => gmdate("Y-m-d", ($row[0] - 25569) * 86400),
        ]);
    }
}
