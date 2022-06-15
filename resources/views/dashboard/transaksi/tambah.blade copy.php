@extends('layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

    <h1 class="h2">Tambah Transaksi</h1>

</div>
    <!-- Modal Input -->
        <!-- Formnya -->
        <form action="/transaksi" method="POST" accept-charset="UTF-8">
        @csrf
            <div class="mb-3 {{ $errors->has('kodetransaksi') ? ' has-error' : '' }}">
                <label for="kodetransaksi" class="form-label">Kode Transaksi</label>
                <input type="text" class="form-control @error('kodetransaksi') is-invalid @enderror" id="kodetransaksi" name="kodetransaksi" required value="{{ old('kodetransaksi') }}">
            @error('kodetransaksi')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
            </div>
            <div class="mb-3" {{ $errors->has('operator') ? ' has-error' : '' }}>
                <label for="operator" class="form-label">Operator</label>
                <input type="text" class="form-control @error('operator') is-invalid @enderror" id="operator" name="operator" value="{{ old('operator') }}">
                @error('operator')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-3" {{ $errors->has('totalbayar') ? ' has-error' : '' }}>
                <label for="totalbayar" class="form-label">Total Bayar</label>
                <input type="text" class="form-control @error('totalbayar') is-invalid @enderror" id="totalbayar" name="totalbayar" value="{{ old('totalbayar') }}">
                @error('totalbayar')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="row" id="tambah">
                <div class="mb-3 col" {{ $errors->has('namaproduk') ? ' has-error' : '' }}>
                    <label for="namapegawai" class="form-label">Nama Produk</label>
                    <input type="text" class="form-control @error('namaproduk') is-invalid @enderror" id="namaproduk" name="namaproduk" required value="{{ old('namaproduk') }}">
                    @error('namaproduk')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3 col" {{ $errors->has('jumlahproduk') ? ' has-error' : '' }}>
                    <label for="jumlahproduk" class="form-label">Jumlah</label>
                    <input type="number" class="form-control @error('jumlahproduk') is-invalid @enderror" id="jumlahproduk" name="jumlahproduk" required value="{{ old('jumlahproduk') }}">
                    @error('jumlahproduk')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="col">
                    <label for="jumlahproduk" class="form-label">Tindakan</label>
                    <button type="button" class="form-control btn btn-danger">Hapus</button>
                </div>
            </div>
            <div>

            </div>
            <div class=" row">
                <div class="col mb-3">
                    <button type="button" class="form-control btn btn-info">Tambah</button>
                </div>
            </div>
            <a href="/staf" class="btn btn-secondary" role="button">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
        <div class="row">
            <div class="col mb-3">
                <input type="text" class="form-control" id="namaproduk" name="namaproduk" value="{{ old('namaproduk') }}">
            </div>
        </div>
        <script>

        </script>

@endsection
