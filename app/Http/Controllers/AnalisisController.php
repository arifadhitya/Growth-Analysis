<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Analisis;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;

use App\Http\Controllers\FPGrowth\FPGrowth;

class AnalisisController extends Controller
{
    public function index()
    {
        //$datauser = User::all();
        return view('dashboard/analisis/index');
    }

    public function fpgrowth(Request $request)
    {
        $credentials = $request->validate([
            'jangkaWaktuAnalisis1' => 'required',
            'jangkaWaktuAnalisis2' => 'required',
            'inputMinSupport' => 'required',
            'inputMinConf' => 'required',
        ]);

        $newDateFormat1 = strtotime($request['jangkaWaktuAnalisis1']);
        $newDateFormat2 = strtotime($request['jangkaWaktuAnalisis2']);
        $minSupp = $request['inputMinSupport'];
        $minConf = $request['inputMinConf'];

        $request['jangkaWaktuAnalisis1'] = date('Y-m-d', $newDateFormat1);
        $request['jangkaWaktuAnalisis2'] = date('Y-m-d', $newDateFormat2);

        $transaksiPembelian=array();
        $namaProduk=array();

        // Mengambil record antara jangka waktu
        $getRecordRange = DB::table('transaksis')->whereBetween('tanggaljual', [
            $request['jangkaWaktuAnalisis1'],
            Carbon::parse($request['jangkaWaktuAnalisis2'])->endOfDay(),
        ])->get();

        // Memasukkan kodeproduk ke array kodetransaksi
        foreach ($getRecordRange as $transaksi => $value) {
            $dettran = DB::table('pembelians')->where('kodetransaksi', $value->kodetransaksi)->get();

            //array_push($tampung, $value->kodetransaksi);
            $x=array();
            $y=array();
            foreach ($dettran as $transaksi => $value){
                $produk = DB::table('produks')->where('kodeproduk', $value->kodeproduk)->first();
                $namaProduk[$value->kodeproduk] = $produk->namaproduk;
                array_push($y, $produk->namaproduk);
                array_push($x, $value->kodeproduk);
            }
            $transaksiPembelian[$value->kodetransaksi] = $x;


        }

        // foreach ($getRecordRange as $transaksi => $value) {
        //     $dettran = DB::table('pembelians')->where('kodetransaksi', $value->kodetransaksi)->get();
        //     $produk = DB::table('produks')->where('kodeproduk', $value->kodeproduk)->get();
        //     dd($transaksi);
        //     $y=array();
        //     foreach ($produk as $kodpro => $value){
        //         array_push($y, $value->namaproduk);
        //         dd($produk);
        //     }
        //     $transaksiPembelian[$value->kodetransaksi] = $x;
        // }


        $confidence = 0.7;

        $fpgrowth = new FPGrowth($minSupp, $confidence);

        $fpgrowth->run($transaksiPembelian);

        $patterns = $fpgrowth->getPatterns();
        $rules = $fpgrowth->getRules();
        //dd($transaksiPembelian);

        return view('dashboard/analisis/result', [
            'transaksiPembelian' => $transaksiPembelian,
            'namaProduk' => $namaProduk,
            'patterns' => $patterns,
            'rules' => $rules,
        ]);
    }
}


