<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Analisis;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;

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
        ])->limit(50)->get();

        $fpgrowth = new FPGrowth();
        foreach ($tran as $transaksi => $value) {
            $dettran = DB::table('pembelians')->where('kodetransaksi', $value->kodetransaksi)->get();
            $tampung = [];
            foreach ($dettran as $transaksi => $value) {
                $tampung[$value->kodeproduk] =$value->kodeproduk;
            }
            $fpgrowth->set($tampung);
        }

        // Menampilkan frequent 1-item
        echo "Output Frequent 1-item : ";
        $fpgrowth->get();
        // Menghitung support count untuk setiap item
        $fpgrowth->countSupportCount();
        // Menampilkan item support count
        echo "Item | Support Count not ordered";
        $fpgrowth->getSupportCount();
        // Mengurutkan item by support count
        $fpgrowth->orderBySupportCount();
        echo "Item | Support Count ordered";
        $fpgrowth->getSupportCount();
        $fpgrowth->removeByMinimumSupport($fpgrowth->supportCount);
        echo "Item | Support Count remove support count < minimum support count";
        $fpgrowth->getSupportCount();
        // Mengurutkan frequent 1-item berdasarkan support count
        // dan menghilangkan item dengan support count kurang dari minimum support count
        $fpgrowth->orderFrequentItem($fpgrowth->frequentItem, $fpgrowth->supportCount);
        // Menampilkan urutan tampilan berdasarkan support count
        // echo "Output Frequent 1-item ordered by support count on each item";
        // $fpgrowth->getOrderedFrequentItem();


        echo "Array After Pruning";
        $fpgrowth->arrayAfterPruning();


        echo "FP Tree result dislpay in array";
        $fpgrowth->FPTree = $fpgrowth->buildFPTree($fpgrowth->orderedFrequentItem);
        $fpgrowth->getFPTree();

        ksort($fpgrowth->supportCount);
        echo '<pre>';
        print_r($fpgrowth->supportCount);
        echo '</pre>';

        $pattern_base = [];
        foreach ($fpgrowth->supportCount as $key => $value) {
            // $pattern_base = $fpgrowth->FPTree[0]['child'][];
        }

        echo '<pre>';
        print_r($fpgrowth->FPTree[0]['child']);
        echo '</pre>';


    }


}

class FPGrowth
{
    public $frequentItem;
    public $minimumSupportCount;
    public $minConfidence;
    public $supportCount;
    public $orderedFrequentItem;
    public $FPTree;

    function __construct()
    {
        $this->frequentItem = array();
        $this->minimumSupportCount = 2;
        $this->minConfidence = 60 * 0.01;
        $this->supportCount = array();
        $this->orderedFrequentItem = array();
    }

    /*
     *input array of frequent pattern
     */
    public function set($t)
    {
        if (is_array($t)) {
            $this->frequentItem[] = $t;
        }
    }

    public function get()
    {
        echo "<pre>";
        print_r($this->frequentItem);
        echo "</pre>";
    }

    public function getFrequentItem()
    {
        echo "<pre>";
        print_r($this->frequentItem);
        echo "</pre>";
    }

    public function orderFrequentItem($frequentItem, $supportCount)
    {
        foreach ($frequentItem as $k => $v) {
            $ordered = array();
            foreach ($supportCount as $key => $value) {
                if (isset($v[$key])) {
                    $ordered[$key] = $v[$key];
                }
            }
            $this->orderedFrequentItem[$k] = $ordered;
        }
    }

    public function getOrderedFrequentItem()
    {
        echo "<pre>";
        print_r($this->orderedFrequentItem);
        echo "</pre>";
    }

    public function countSupportCount()
    {
        if (is_array($this->frequentItem)) {
            foreach ($this->frequentItem as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $k => $v) {
                        // dd($this->supportCount[]);
                        if (empty($this->supportCount[$v])) {
                            $this->supportCount[$v] = 1;
                        }
                        else {
                            $this->supportCount[$v] = $this->supportCount[$v] + 1;
                        }
                    // dd($value);
                    }
                }
            }
        }
    }

    public function getSupportCount()
    {
        echo "<pre>";
        print_r($this->supportCount);
        echo "</pre>";
    }

    public function orderBySupportCount()
    {
        ksort($this->supportCount);
        arsort($this->supportCount);
    }

    public function removeByMinimumSupport($supportCount)
    {
        if (is_array($supportCount)) {
            $this->supportCount = array();
            foreach ($supportCount as $key => $value) {
                if ($value >= $this->minimumSupportCount) {
                    $this->supportCount[$key] = $value;
                }
            }
        }
    }

    // Setelah pruning untuk dibuat Tree
    public function arrayAfterPruning(){
        if (is_array($this->frequentItem)) {
            foreach ($this->frequentItem as $key => $value) {
                if($this->frequentItem[$value][1] >= $this->minimumSupportCount){
                    print_r($this->frequentItem[$value][1]);
                }
            }

            echo "<pre>";
            print_r($this->orderedFrequentItem);
            echo "</pre>";
        }
    }

    /* struktur array
     * item  : (I1, I2, dst)
     * count : (2, 3, 4)
     * child : (next array)
     */
    public function buildFPTree($orderedFrequentItem)
    {
        $FPTree[] = array(
            'item' => 'null',
            'count' => 0,
            'child' => null,
        );
        $FPTree2[] = array();
        if (is_array($orderedFrequentItem)) {
            $i = 0;
            foreach ($orderedFrequentItem as $orderedFrequentItemKey => $orderedFrequentItemValue) {
                // inisiasi ke FPTree 0 // save key FPTree sementara
                $FPTreeTemp = $FPTree[0];
                $FPTreeTempKey = array(0);

                foreach ($orderedFrequentItemValue as $itemKey => $itemValue) {
                    // add key FPTree sementara
                    array_push($FPTreeTempKey, $itemValue);

                    // insert tree ke FPTree
                    switch ((count($FPTreeTempKey))) {
                        case 2:
                            if (empty($FPTree[0]['child'][$itemValue])) {
                                $FPTree[0]['child'][$itemValue] = array(
                                    'item' => $itemValue,
                                    'count' => 1,
                                    'child' => null,
                                );
                            }
                            else {
                                $FPTree[0]['child'][$itemValue]['count'] = $FPTree[0]['child'][$itemValue]['count'] + 1;
                            }
                            break;

                        case 3:
                            if (empty($FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$itemValue])) {
                                $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$itemValue] = array(
                                    'item' => $itemValue,
                                    'count' => 1,
                                    'child' => null,
                                );
                            }
                            else {
                                $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$itemValue]['count'] = $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$itemValue]['count'] + 1;
                            }
                            break;

                        case 4:
                            if (empty($FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$itemValue])) {
                                $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$itemValue] = array(
                                    'item' => $itemValue,
                                    'count' => 1,
                                    'child' => null,
                                );
                            }
                            else {
                                $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$itemValue]['count'] = $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$itemValue]['count'] + 1;
                            }
                            break;

                        case 5:
                            if (empty($FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$FPTreeTempKey[3]]['child'][$itemValue])) {
                                $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$FPTreeTempKey[3]]['child'][$itemValue] = array(
                                    'item' => $itemValue,
                                    'count' => 1,
                                    'child' => null,
                                );
                            }
                            else {
                                $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$FPTreeTempKey[3]]['child'][$itemValue]['count'] = $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$FPTreeTempKey[3]]['child'][$itemValue]['count'] + 1;
                            }
                            break;

                        default:

                            break;
                    }
                }
            }
        }
        return $FPTree;
    }

    public function getFPTree()
    {
        echo "<pre>";
        print_r($this->FPTree);
        echo "</pre>";
    }

}
