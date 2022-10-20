<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Analisis;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\FPGrowth\FPGrowth;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

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
        foreach ($getRecordRange as $transaksi1 => $value1) {
            $dettran = DB::table('pembelians')->where('kodetransaksi', $value1->kodetransaksi)->get();

            //array_push($tampung, $value->kodetransaksi);
            $x=array();
            $y=array();
            foreach ($dettran as $transaksi2 => $value2){
                $produk = DB::table('produks')->where('kodeproduk', $value2->kodeproduk)->first();
                $namaProduk[$value2->kodeproduk] = $produk->namaproduk;
                array_push($y, $produk->namaproduk);
                array_push($x, $value2->kodeproduk);
                $transaksiPembelian[$transaksi1] = $x;
            }
            if(isset($transaksiPembelian[$transaksi1])){
                $transaksiPembelian[$transaksi1] = array_unique($transaksiPembelian[$transaksi1]);
            }

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


        $support = 2;
        $confidence = 0;

        $fpgrowth = new FPGrowth($minSupp, $minConf);
        $transactions = [
            ['I1', 'I2', 'I5'],
            ['I2', 'I4'],
            ['I2', 'I3'],
            ['I1', 'I2', 'I4'],
            ['I1', 'I3'],
            ['I2', 'I3'],
            ['I1', 'I3'],
            ['I1', 'I2', 'I3', 'I5'],
            ['I1', 'I2', 'I3']



            // ['M', 'O', 'N', 'K', 'E', 'Y'],
            // ['D', 'O', 'N', 'K', 'E', 'Y'],
            // ['M', 'A', 'K', 'E'],
            // ['M', 'U', 'C', 'K', 'Y'],
            // ['C', 'O', 'O', 'K', 'I', 'E']
        ];

        $transactionsB = [
            ['P3', 'P1', 'P2'],
            ['P4', 'P10', 'P11', 'P5', 'P6', 'P7', 'P8', 'P9'],
            ['P13', 'P12', 'P14', 'P15'],
            ['P16', 'P17', 'P19', 'P18', 'P20'],
            ['P4', 'P23', 'P21', 'P26', 'P22', 'P24', 'P25'],
            ['P27', 'P13', 'P28', 'P30', 'P29', 'P31', 'P32'],
            ['P34', 'P35', 'P37', 'P38', 'P33', 'P36'],
            ['P30', 'P44', 'P46', 'P39', 'P40', 'P41', 'P42', 'P43', 'P45', 'P47'],
            ['P50', 'P44', 'P51', 'P48', 'P49', 'P52', 'P53'],
            ['P3'],

        ];
        foreach ($transactions as $transaction => $value){
            if($transactions[$transaction]){
                $transactions[$transaction] = array_unique($transactions[$transaction]);
            }
        }
        $fpgrowth->run($transactions);
        // $fpgrowth->run($transaksiPembelian);
        $patterns = $fpgrowth->getPatterns();
        $rules = $fpgrowth->getRules();
        $columns = array_column($rules, 2);
        array_multisort($columns, SORT_DESC, $rules);


        dd($rules);

        foreach($rules as $index=>$aturan){
            foreach($aturan as $indexX=>$aturanX){
                if (is_string($aturanX)){
                    $rules[$index][$indexX] = explode(',', $aturanX);
                }

                // $aturanX[0] = explode(',', $rules[$aturanX]);
                // $aturanX[1] = explode(',', $patterns[1]);
            }
        }


        // dd($rules);
        // dd($transaksiPembelian);
        return view('dashboard/analisis/result', [
            'transaksiPembelian' => $transaksiPembelian,
            'namaProduk' => $namaProduk,
            'patterns' => $patterns,
            'rules' => $rules,
            'minSupp' => $minSupp,
            'minConf' => $minConf,
            'newDateFormat1' => $newDateFormat1,
            'newDateFormat2' => $newDateFormat2,
        ]);
    }
}


