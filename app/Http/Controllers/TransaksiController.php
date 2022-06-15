<?php

namespace App\Http\Controllers;

use App\Imports\ProdukImport;
use Maatwebsite\Excel\Facades\Excel;

use Session;

use App\Models\Pembelian;
use App\Models\Transaksi;
use Illuminate\Http\Request;

use App\Imports\DetailTransaksiImport;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreTransaksiRequest;
use App\Http\Requests\UpdateTransaksiRequest;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTransaksiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransaksiRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function show(Transaksi $transaksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTransaksiRequest  $request
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransaksiRequest $request, Transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaksi $transaksi)
    {
        //
    }

    public function import(Request $request){

        // validasi
        $validatedData = $request->validate([
            'fileImportDetailTrans' => 'required|mimes:csv,xls,xlsx'
        ]);
        // dd('helloworld');
        if($request->file('fileImportDetailTrans')){
            $file = $request->file('fileImportDetailTrans');
            $nama_file = rand().$file->getClientOriginalName();
            $validatedData['fileImportDetailTrans'] = $request->file('fileImportDetailTrans')->move('file_importDetailTransaksi',$nama_file);
            Excel::import(new DetailTransaksiImport, public_path('/file_importDetailTransaksi/'.$nama_file));
            Session::flash('sukses','Data Transaksi Berhasil Diimport!');
        }

		// alihkan halaman kembali
		return redirect('/transaksi');
    }


}
