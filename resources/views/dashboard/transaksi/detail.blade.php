@extends('layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

    <h1 class="judul-page">Detail Transaksi {{ $detail[0]->kodetransaksi }}</h1>

    <a href="/transaksi"><button class="btn btn-flat btn-rv">Kembali
    </button></a>

    <!-- Trigger Modal Input-->
    {{-- <form action="/transaksi/{{ $detail[0]->id }}/hapus" method="post" class="d-inline">
        @csrf
        <button class="btn btn-danger btn-flat" onclick="return confirm('Konfirmasi Hapus ?')">Hapus</button>
    </form> --}}

    <!-- Modal Input -->
    <div class="modal fade" id="modalInput" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Tambah Transaksi</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            ...
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary">Simpan</button>
        </div>
        </div>
    </div>
    </div>

</div>
<table class="table table-borderless">
    <tr>
        <th>No</th>
        <th>Kode Produk</th>
        <th>Jumlah</th>
        <th>Total Bayar</th>
        <th>Tanggal Transaksi</th>
    </tr>
    @foreach($detail as $tr)
	<tr>
		<td>{{$loop->iteration}}</td>
		<td>{{$tr->kodeproduk}}</td>
        <td>{{$tr->jumlahproduk}}</td>
        <td>{{$tr->totalbayar}}</td>
        <td>{{ date('d/m/Y', strtotime($tr->tanggaltransaksi)) }}</td>
	</tr>
	@endforeach
</table>



@endsection
