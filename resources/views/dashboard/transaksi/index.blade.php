@extends('layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

    <h1 class="judul-page">Data Transaksi</h1>

    <div>
    <!-- Tombol import transaksi -->
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importDataTransaksi">
        Import Transaksi
    </button>
    <!-- Tombol import detail transaksi -->
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importDetailTransaksi">
        Import Detail Transaksi
    </button>
    <!-- Trigger Modal Input-->
    {{-- <a href="/transaksi/tambah" class="btn btn-primary" role="button">Tambah</a> --}}
    </div>

    <!-- Modal -->

  <div class="modal fade" id="importDataTransaksi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <form action="/importtransaksi" method="POST" enctype="multipart/form-data">

    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="importDataTransaksi">Import Transaksi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            @csrf
          File harus mengikuti format seperti pada gambar.
          <div>
            <img src="/img/cth_tabel_transaksiumum.png" alt="" class="img-fluid">
          </div>
          Tanpa header tabel.
          <div class="mb-3">
            <label for="importTransaksi" class="form-label"></label>
            <input class="form-control" type="file" name="fileImportTrans" id="importTransaksi" required="required">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-rv" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-rvr">Proses</button>
        </div>
      </div>
    </div>
  </form>
  </div>


  <!-- Modal Detail Transaksi-->

  <div class="modal fade" id="importDetailTransaksi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <form action="/importdetailtransaksi" method="POST" enctype="multipart/form-data">

    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="importDetailTransaksi">Import Detail Transaksi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            @csrf
          File harus mengikuti format seperti pada gambar.
          <div>
            <img src="/img/cth_tabel_transaksidetil.png" alt="" class="img-fluid">
          </div>
          Tanpa header tabel.
          <div class="mb-3">
            <label for="detailTransaksi" class="form-label"></label>
            <input class="form-control" type="file" name="fileImportDetailTrans" id="detailTransaksi" required="required">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-rv" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-rvr">Proses</button>
        </div>
      </div>
    </div>
  </form>
  </div>


</div>
<div class="row my-auto">
    <div class="col paginate">
        {{ $datatransaksi->links() }}
    </div>
    <form action="/transaksi" class="col pencarian">
        <div class="input-group">
            <button class="btn btn-outline-secondary btn-rv" type="submit"><i class="bi bi-search"></i></button>
            <input type="text" class="form-control" name="search" placeholder="Cari berdasarkan Kode transaksi (cth. NF-2107200001)">
        </div>
    </form>
</div>

@if(session()->has('message'))
    <div class="alert alert-warning">
        {{ session()->get('message') }}
    </div>
@endif

<table class="table table-borderless">
    <tr>
        <th>No</th>
        <th>Kode Transaksi</th>
        <th>Total Bayar</th>
        <th>Operator</th>
        <th>Tanggal Transaksi</th>
        <th>Tindakan</th>
    </tr>
    @foreach($datatransaksi as $tr)
	<tr>
		<td>{{$loop->iteration}}</td>
		<td>{{$tr->kodetransaksi}}</td>
        <td>{{$tr->totalbayar}}</td>
        <td>{{$tr->operator}}</td>
        <td>{{ date('d/m/Y', strtotime($tr->tanggaljual)) }}</td>
		<td>
			{{-- <form action="/transaksi/{{ $tr->id }}/edit" method="post" class="d-inline">
                @csrf
                <button class="btn btn-warning btn-flat" onclick="return confirm('Konfirmasi Ubah ?')">Ubah</button>
            </form> --}}


            <form action="/transaksi/detail/{{ $tr->kodetransaksi }}" method="post" class="d-inline">
                @csrf
                <button class="btn btn-secondary btn-flat">Detail</button>
            </form>
            <form action="/transaksi/{{ $tr->id }}/hapus" method="post" class="d-inline">
                @csrf
                <button class="btn btn-outline-secondary btn-flat" onclick="return confirm('Konfirmasi Hapus ?')">Hapus</button>
            </form>
		</td>
	</tr>
	@endforeach
</table>
@endsection
