<?php

namespace App\Http\Controllers;

use App\Imports\ProdukImport;
use Maatwebsite\Excel\Facades\Excel;

use Session;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$dataproduk = Produk::all();
        $dataproduk=DB::table('produks')->paginate(10);
        return view('dashboard/produk/index', ['dataproduk' => $dataproduk]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        return view('dashboard/produk/tambah');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //print_r($request->inputKodeProduk);
        $validatedData = $request->validate([
            'kodeproduk' => 'required|unique:produks',
            'namaproduk' => 'required|max:255',
            'satuan' => 'required|max:255',
            'hargabeli' => 'required|max:255',
            'hargajual' => 'required|max:255',
        ]);
        Produk::create($validatedData);
        return redirect('/produk')->with('success', 'Data produk telah ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function show(Produk $produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function edit(Produk $produk)
    {
        return view('dashboard/produk/ubah', [
            'produk' => $produk,

        ]);
    }

    public function update(Request $request, Produk $produk)
    {
        $rules = [
            'namaproduk' => 'required|max:255',
            'satuan' => 'required|max:255',
            'hargabeli' => 'required|max:255',
            'hargajual' => 'required|max:255',
        ];

        if($request->kodeproduk != $produk->kodeproduk){
            $rules['kodeproduk'] = 'required|max:255';
        };

        $validatedData = $request->validate($rules);

        Produk::where('id', $produk->id) -> update($validatedData);

        return redirect('/produk')->with('success', 'Data produk telah diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produk $produk)
    {
        Produk::destroy($produk->id);
        return redirect('/produk')->with('success', 'Produk dihapus');
    }

    public function import(Request $request){

        // validasi
        $validatedData = $request->validate([
            'fileImport' => 'required|mimes:csv,xls,xlsx'
        ]);

        if($request->file('fileImport')){
            $file = $request->file('fileImport');
            $nama_file = rand().$file->getClientOriginalName();
            $validatedData['fileImport'] = $request->file('fileImport')->move('file_importProduk',$nama_file);
            Excel::import(new ProdukImport, public_path('/file_importProduk/'.$nama_file));
            Session::flash('sukses','Data Produk Berhasil Diimport!');
        }

		// $this->validate($request, [
        //     'file' => 'required|mimes:csv,xls,xlsx'
        // ]);

		// // menangkap file excel
		// $file = $request->file('file');

		// // membuat nama file unik
		// $nama_file = rand().$file->getClientOriginalName();

        // dd($nama_file);
		// // upload ke folder file_siswa di dalam folder public
		// $file->move('file_importProduk',$nama_file);

		// import data
		// Excel::import(new ProdukImport, public_path('/file_importProduk/'.$nama_file));

		// // notifikasi dengan session
		// Session::flash('sukses','Data Produk Berhasil Diimport!');

		// alihkan halaman kembali
		return redirect('/produk');
    }
}
