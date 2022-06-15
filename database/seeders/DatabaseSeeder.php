<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transaksis')->insert([
            'kodetransaksi' => 'TR001',
            'totalbayar' => '2000',
            'operator' => 'fulan',
        ]);

        DB::table('transaksis')->insert([
            'kodetransaksi' => 'TR002',
            'totalbayar' => '3000',
            'operator' => 'fulanah',
        ]);

        DB::table('produks')->insert([
            'kodeproduk' => '89686000061',
            'namaproduk' => 'MIE CAP 3 AYAM MIE PIPIH 200G',
            'satuan' => 'BKS',
            'hargabeli' => 'Rp3,748',
            'hargajual' => 'Rp4,500',
        ]);

        DB::table('produks')->insert([
            'kodeproduk' => '89686010015',
            'namaproduk' => 'INDOMIE AYAM BAWANG 69G',
            'satuan' => 'BKS',
            'hargabeli' => 'Rp2,367',
            'hargajual' => 'Rp2,700',
        ]);

        DB::table('produks')->insert([
            'kodeproduk' => '89686010107',
            'namaproduk' => 'INDOMIE KALDU AYAM 75G',
            'satuan' => 'BKS',
            'hargabeli' => 'Rp2,124',
            'hargajual' => 'Rp2,400',
        ]);

        DB::table('produks')->insert([
            'kodeproduk' => '89686010190',
            'namaproduk' => 'INDOMIE KARI AYAM 72G',
            'satuan' => 'BKS',
            'hargabeli' => 'Rp2,522',
            'hargajual' => 'Rp2,800',
        ]);

        DB::table('produks')->insert([
            'kodeproduk' => '89686010343',
            'namaproduk' => 'INDOMIE SOTO MIE 70G',
            'satuan' => 'BKS',
            'hargabeli' => 'Rp2,367',
            'hargajual' => 'Rp2,700',
        ]);

        DB::table('pembelians')->insert([
            'kodetransaksi' => 'TR001',
            'kodeproduk' => '89686000061',
            'jumlahproduk' => '1',
            'totalbayar' => '3000',
            'operator' => 'fulanah',
        ]);

        DB::table('pembelians')->insert([
            'kodetransaksi' => 'TR001',
            'kodeproduk' => '89686010015',
            'jumlahproduk' => '1',
            'totalbayar' => '3000',
            'operator' => 'fulanah',
        ]);

        DB::table('pembelians')->insert([
            'kodetransaksi' => 'TR001',
            'kodeproduk' => '89686010107',
            'jumlahproduk' => '1',
            'totalbayar' => '3000',
            'operator' => 'fulanah',
        ]);

        DB::table('pembelians')->insert([
            'kodetransaksi' => 'TR002',
            'kodeproduk' => '89686010190',
            'jumlahproduk' => '1',
            'totalbayar' => '3000',
            'operator' => 'fulanah',
        ]);

        DB::table('pembelians')->insert([
            'kodetransaksi' => 'TR002',
            'kodeproduk' => '89686010343',
            'jumlahproduk' => '1',
            'totalbayar' => '3000',
            'operator' => 'fulanah',
        ]);
    }
}
