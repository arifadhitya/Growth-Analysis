@extends('layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

    <h1 class="judul-page">Ubah Data Staf {{ $staf->kodepegawai }}</h1>

</div>
    <!-- Modal Input -->
        <!-- Formnya -->
        <form action="/staf/{{ $staf->id }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
        @csrf
            <div class="mb-3 {{ $errors->has('kodepegawai') ? ' has-error' : '' }}">
                <label for="kodepegawai" class="form-label">Nomor Induk</label>
                <input type="text" class="form-control @error('kodepegawai') is-invalid @enderror" id="kodepegawai" name="kodepegawai" required value="{{ old('kodepegawai', $staf->kodepegawai) }}" disabled>
            @error('kodepegawai')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
            </div>
            <div class="mb-3" {{ $errors->has('namapegawai') ? ' has-error' : '' }}>
                <label for="namapegawai" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control @error('namapegawai') is-invalid @enderror" id="namapegawai" name="namapegawai" required value="{{ old('namapegawai', $staf->namapegawai) }}">
                @error('namapegawai')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-3" {{ $errors->has('username') ? ' has-error' : '' }}>
                <label for="username" class="form-label">Nama Pengguna</label>
                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username', $staf->username) }}">
                @error('username')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-3" {{ $errors->has('password') ? ' has-error' : '' }}>
                <label for="password" class="form-label">Kata Sandi</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                <input class="form-check-input me-1" type="checkbox" value="" aria-label="" onclick="tampilPassword()">Tampilkan Kata Sandi
                @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="profil" class="form-label">Pilih file foto profil</label>
                <input class="form-control @error('profil') is-invalid @enderror" type="file" id="profil" name="profil">
                @error('profil')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <a href="/staf" class="btn btn-rv" role="button">Batal</a>
            <button type="submit" class="btn btn-rvr">Simpan Perubahan</button>
        </form>

@endsection
