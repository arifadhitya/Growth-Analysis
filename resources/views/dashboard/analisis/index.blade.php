@extends('layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

    <h1 class="judul-page">Analisis FP-Growth</h1>

    <div>
    <!-- Tombol import -->
    {{-- <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importDataProduk">
        Import
    </button> --}}
    <!-- Tombol tambah produk -->
    {{-- <a href="/produk/tambah" class="btn btn-primary" role="button">Tambah</a> --}}
    </div>

</div>

<form action="/analisisproduk" method="POST" accept-charset="UTF-8" class="d-flex-start w-75">
    @csrf
        <div class="row mb-3">
            <div class="col">
                <label for="jangkaWaktuAnalisis1" class="form-label">Jangka waktu</label>
                <input type="text" class="form-control datepicker" id="jangkaWaktuAnalisis1" name="jangkaWaktuAnalisis1" placeholder="Tanggal awal" required>
            </div>
            <div class="col">
                <label for="jangkaWaktuAnalisis2" class="form-label">Sampai dengan</label>
                <input type="text" class="form-control datepicker" id="jangkaWaktuAnalisis2" name="jangkaWaktuAnalisis2" placeholder="Tanggal akhir" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="inputMinSupport" class="form-label">Minimum Support</label>
            <input type="text" class="form-control" id="inputMinSupport" name="inputMinSupport" placeholder="Batasan nilai Support yang akan dieksekusi program (cth. 3)" required>
        </div>
        <div class="mb-3">
            <label for="inputMinConf" class="form-label">Minimum Confidence</label>
            <input type="text" class="form-control" id="inputMinConf" name="inputMinConf" placeholder="Batasan kandidat kuat (0.0 sampai 1.0, cth. '0.5')" required>
        </div>

        <button type="submit" class="btn btn-rvr">Proses</button>
    </form>




@endsection
