@extends('layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="judul-page">Staf</h1>

    <!-- Tombol tambah produk -->
    <a href="/staf/tambah" class="btn btn-rvr" role="button">Tambah</a>

</div>
@if (session()->has('success'))
  <div class="alert alert-info" role="alert">
    {{ session('success') }}
  </div>
@endif
<table class="table table-borderless">
    <tr>
        <th>No</th>
        <th>Kode Pegawai</th>
        <th>Nama Pegawai</th>
        <th>Username</th>
        {{-- <th>Profil</th> --}}
        <th>Tindakan</th>
    </tr>
    @foreach($datauser as $ur)
	<tr>
		<td>{{$loop->iteration}}</td>
		<td>{{$ur->kodepegawai}}</td>
		<td>{{$ur->namapegawai}}</td>
        <td>{{$ur->username}}</td>
        {{-- <td><img src="{{ asset('storage/' . $ur->profil) }}" class="profile-pic"></td> --}}
		<td>
			<form action="/staf/{{ $ur->id }}/edit" method="post" class="d-inline">
                @csrf
                <button class="btn btn-rvr btn-flat" onclick="return confirm('Konfirmasi Ubah ?')">Ubah</button>
            </form>
			<form action="/staf/{{ $ur->id }}/hapus" method="post" class="d-inline">
                @csrf
                <button class="btn btn-rv btn-flat" onclick="return confirm('Konfirmasi Hapus ?')">Hapus</button>
            </form>
		</td>
	</tr>
	@endforeach
</table>
@endsection
