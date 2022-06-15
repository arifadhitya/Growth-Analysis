@extends('layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

    <h1 class="h2">Tambah Produk</h1>

</div>
    <!-- Modal Input -->
        <!-- Formnya -->
        <form action="/produk" method="POST" accept-charset="UTF-8">
        @csrf
            <div class="mb-3 {{ $errors->has('inputKodeProduk') ? ' has-error' : '' }}">
                <label for="inputKodeProduk" class="form-label">Kode Produk</label>
                <input type="text" class="form-control @error('inputKodeProduk') is-invalid @enderror" id="inputKodeProduk" name="kodeproduk" required>

            </div>
            <div class="mb-3">
                <label for="inputNamaProduk" class="form-label">Nama Produk</label>
                <input type="text" class="form-control" id="inputNamaProduk" name="namaproduk" required>
                <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
            </div>
            <div class="mb-3">
                <label for="inputSatuanProduk" class="form-label">Satuan</label>
                <input type="text" class="form-control" id="inputSatuanProduk" name="satuan">
                <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
            </div>
            <div class="mb-3">
                <label for="inputHargabeliProduk" class="form-label">Harga Beli</label>
                <input type="text" class="form-control" id="inputHargabeliProduk" name="hargabeli">
                <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
            </div>
            <div class="mb-3">
                <label for="inputHargajualProduk" class="form-label">Harga Jual</label>
                <input type="text" class="form-control" id="inputHargajualProduk" name="hargajual">
                <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
            </div>
            <a href="/produk" class="btn btn-secondary" role="button">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>

@endsection
