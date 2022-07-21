<?php

namespace App\Http\Controllers;

use App\Imports\ProdukImport;
use Maatwebsite\Excel\Facades\Excel;

use Session;

use App\Models\Pembelian;
use App\Models\Transaksi;
use Illuminate\Http\Request;

use App\Imports\TransaksiImport;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorePembelianRequest;
use App\Http\Requests\UpdatePembelianRequest;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard/transaksi/index', [
            'datatransaksi' => Transaksi::latest()->Pencarian(request(['search']))->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard/transaksi/tambah');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePembelianRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kodetransaksi' => 'required|unique:transaksis',
            'totalbayar' => 'required|max:255',
            'operator' => 'required|max:255',
        ]);
        Transaksi::create($validatedData);

        for ($i=0; $i < count($request->namaproduk); $i++){
            $validatedData['kodeproduk']=$request->namaproduk[$i];
            $validatedData['jumlahproduk']=$request->jumlahproduk[$i];
            Pembelian::create($validatedData);
        }

        return redirect('/transaksi')->with('success', 'Data staf telah ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function show(Pembelian $pembelian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaksi  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $pembelian)
    {
        //$datatransaksi = Pembelian::with(['transaksi', 'produk'])->get();
        dd($pembelian->id);
        // dd();die;
        $pembelian = Pembelian::where('id',$pembelian)->get();
        dd($pembelian);
        return view('dashboard/transaksi/ubah', [
            'pembelian' => $pembelian,
        ]);
    }

    public function detail(Request $request)
    {
        //$datatransaksi = Pembelian::with(['transaksi', 'produk'])->get();
        // dd($pembelian);
        // dd();die;
        $detail = Pembelian::where('kodetransaksi',$request->id)->get();
        // dd($pembelian);
        return view('dashboard/transaksi/detail', [
            'detail' => $detail,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePembelianRequest  $request
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePembelianRequest $request, Pembelian $pembelian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pembelian $pembelian)
    {
        //
    }

    public function import(Request $request){

        // validasi
        $validatedData = $request->validate([
            'fileImportTrans' => 'required|mimes:csv,xls,xlsx'
        ]);
        // dd('helloworld');
        if($request->file('fileImportTrans')){
            $file = $request->file('fileImportTrans');
            $nama_file = rand().$file->getClientOriginalName();
            $validatedData['fileImportTrans'] = $request->file('fileImportTrans')->move('file_importTransaksi',$nama_file);
            Excel::import(new TransaksiImport, public_path('/file_importTransaksi/'.$nama_file));
            Session::flash('sukses','Data Transaksi Berhasil Diimport!');
        }

		// alihkan halaman kembali
		return redirect('/transaksi');
    }
}
