@extends('layouts.main')

@section('container')

@if($errors->any())
<script type='text/javascript'>alert({{ $errors->first() }});</script>"</h4>
@endif

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="judul-page text-align-start">
        Selamat Datang,<br>
        {{ auth()->user()->namapegawai }}
    </h1>
</div>
<h3>Ketentuan</h3>
<ul>
    <li>Data penjualan disiapkan terlebih dahulu.</li>
    <li>Data produk, Data Transaksi Umum, dan Data Transaksi Detail memiliki keterikatan.</li>
    <li>Setiap Data Transaksi Detail harus memiliki kode transaksi dari Data Transaksi Umum.</li>
    <li>Setiap Data Transaksi Umum & Data Transaksi Detail harus memiliki kode produk dari Data Produk.</li>
    <li>Setiap data diupload secara terpisah dalam masing-masing file dengan hanya 1 sheet.</li>
    <li>Urutan upload data baru adalah; 1. Data Produk, 2. Data Transaksi Umum, 3. Data Transaksi Detail.</li>
</ul>



<div class="widget" >
    <a href="https://time.is/Kendari,_North_Kalimantan" id="time_is_link" rel="nofollow" style="font-size:36px;color:#548459; text-decoration:none">Waktu di Kendari:</a>
    <span id="Kendari__North_Kalimantan_z42b" style="font-size:36px;color:#548459"></span>
    <script src="//widget.time.is/id.js"></script>
    <script>
    time_is_widget.init({Kendari__North_Kalimantan_z42b:{template:"TIME<br>DATE", date_format:"dayname, dnum monthname year"}});
    </script>
</div>

@endsection
