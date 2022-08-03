@extends('layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

    <h1 class="judul-page">Ubah Data Produk {{ $produk->kodeproduk }}</h1>

</div>
        <form action="/produk/{{ $produk->id }}/update" method="POST" accept-charset="UTF-8">
        @csrf
            <div class="mb-3">
                <label for="kodeproduk" class="form-label">Kode Produk</label>
                <input type="text" class="form-control @error('kodeproduk') is-invalid @enderror" id="kodeproduk"
                name="kodeproduk" required autofocus value="{{ old('kodeproduk', $produk->kodeproduk) }}" disabled>
                @error('kodeproduk')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="namaproduk" class="form-label">Nama Produk</label>
                <input type="text" class="form-control @error('namaproduk') is-invalid @enderror" id="namaproduk" name="namaproduk" required value="{{ old('namaproduk', $produk->namaproduk) }}">
                @error('namaproduk')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="satuan" class="form-label">Satuan</label>
                <input type="text" class="form-control @error('satuan') is-invalid @enderror" id="satuan" name="satuan" value="{{ old('satuan', $produk->satuan) }}">
                @error('satuan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="hargabeli" class="form-label">Harga Beli</label>
                <input type="text" class="form-control @error('hargabeli') is-invalid @enderror" id="hargabeli" name="hargabeli" value="{{ old('hargabeli', $produk->hargabeli) }}">
                @error('hargabeli')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="hargajual" class="form-label">Harga Jual</label>
                <input type="text" class="form-control @error('hargajual') is-invalid @enderror" id="hargajual" name="hargajual" value="{{ old('hargajual', $produk->hargajual) }}">
                @error('hargajual')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <a href="/produk" class="btn btn-rv" role="button">Batal</a>
            <button type="submit" class="btn btn-rvr">Simpan</button>
        </form>
    </div>
    </div>

@endsection
