<?php

namespace App\Imports;

use App\Models\Produk;
use Maatwebsite\Excel\Concerns\ToModel;

class ProdukImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Produk([
            'kodeproduk' => $row[0],
            'namaproduk' => $row[1],
            'satuan' => $row[2],
            'hargabeli' => $row[3],
            'hargajual' => $row[4],
        ]);
    }
}
