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

        // Mengambil record antara jangka waktu
        $getRecordRange = Pembelian::whereBetween('tanggaltransaksi', [
            $request['jangkaWaktuAnalisis1'],
            Carbon::parse($request['jangkaWaktuAnalisis2'])->endOfDay(),
        ])->get();

        // Perulangan masing-masing record
        // foreach ($getRecordRange as $transaksi => $value){

        //     $hitungItemset = Pembelian::where('kodetransaksi', $value->kodetransaksi)->count();

        //     //kalau jumlah itemset lebih dari atau sama dengan minimum confidence
        //     if($hitungItemset >= $minConf){

        //         //masukkan ke tabel analisis
        //         Analisis::create([
        //             'kodetransaksi'=>$value->kodetransaksi,
        //             'totalbayar'=>$value->totalbayar,
        //             'tanggaltransaksi'=>$value->tanggaltransaksi,
        //             'kodeproduk'=>$value->kodeproduk,
        //             'jumlahproduk'=>$value->jumlahproduk,
        //         ]);
        //     }
        //     //isi dalam tabel analisis sesuai range

        // }
        // $tran = DB::table('transaksis')->limit(10)->get();
        $tran = DB::table('transaksis')->whereBetween('tanggaljual', [
            $request['jangkaWaktuAnalisis1'],
            Carbon::parse($request['jangkaWaktuAnalisis2'])->endOfDay(),
        ])->get('kodetransaksi');

        // $fpgrowth = new FPGrowth();
        $tampung=array();
        foreach ($tran as $transaksi => $value) {
            $dettran = DB::table('pembelians')->where('kodetransaksi', $value->kodetransaksi)->get();
            //array_push($tampung, $value->kodetransaksi);
            $x=array();
            foreach ($dettran as $transaksi => $value){
                array_push($x, $value->kodeproduk);
            }
            $tampung[$value->kodetransaksi] = $x;
        }
        // $tampung=array();
        // foreach ($tran as $transaksi => $value) {
        //     $dettran = DB::table('pembelians')->where('kodetransaksi', $value->kodetransaksi)->get();
        //     foreach ($dettran as $transaksi => $value) {
        //         $tampung[$value->kodetransaksi] = array($value->kodeproduk);
        //     }
        //     //$fpgrowth->set($tampung);
        // }

        //dd($tran);



        $transactions = [
            ['M', 'O', 'N', 'K', 'E', 'Y'],
            ['D', 'O', 'N', 'K', 'E', 'Y'],
            ['M', 'A', 'K', 'E'],
            ['M', 'U', 'C', 'K', 'Y'],
            ['C', 'O', 'O', 'K', 'I', 'E'],
        ];

        $support = $minSupp;
        $confidence = 0.7;

        $fpgrowth = new FPGrowth($support, $confidence);

        $fpgrowth->run($tampung);

        $patterns = $fpgrowth->getPatterns();
        $rules = $fpgrowth->getRules();

        dd($rules);


    }
}


