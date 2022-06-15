@extends('layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

    <h1 class="h2">Analisis FP-Growth</h1>

    <div>
    <!-- Tombol import -->
    {{-- <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importDataProduk">
        Import
    </button> --}}
    <!-- Tombol tambah produk -->
    {{-- <a href="/produk/tambah" class="btn btn-primary" role="button">Tambah</a> --}}
    </div>

</div>

<form action="/analisisproduk" method="POST" accept-charset="UTF-8">
    @csrf
        <div class="mb-3">
            <label for="jangkaWaktuAnalisis" class="form-label">Jangka Waktu</label>
            <div class="row">
                <div class="col">
                    <input type="text" class="form-control datepicker" id="jangkaWaktuAnalisis1" name="jangkaWaktuAnalisis1" required>
                </div>
                <div class="col" style="text-align: center">
                    Sampai Dengan
                </div>
                <div class="col">
                    <input type="text" class="form-control datepicker" id="jangkaWaktuAnalisis2" name="jangkaWaktuAnalisis2" required>
                </div>
            </div>


        </div>
        <div class="mb-3">
            <label for="inputMinSupport" class="form-label">Minimum Support</label>
            <input type="text" class="form-control" id="inputMinSupport" name="inputMinSupport" required>
        </div>
        <div class="mb-3">
            <label for="inputMinConf" class="form-label">Minimum Confidence</label>
            <input type="text" class="form-control" id="inputMinConf" name="inputMinConf" required>
        </div>

        <button type="submit" class="btn btn-primary">Proses</button>
    </form>




@endsection
