@extends('layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

    <h1 class="judul-page">Data Produk</h1>

    <div>
    <!-- Tombol import -->
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importDataProduk">
        Import
    </button>
    <!-- Tombol tambah produk -->
    <a href="/produk/tambah" class="btn btn-primary" role="button">Tambah</a>
    </div>

</div>

  <!-- Modal -->

  <div class="modal fade" id="importDataProduk" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <form action="/importproduk" method="POST" enctype="multipart/form-data">

    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="importDataProduk">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            @csrf
          File harus mengikuti format seperti pada gambar.
          <div>
            <img src="/img/cth_tabel_produk.png" alt="" class="img-fluid">
          </div>
          Tanpa header tabel.
          <div class="mb-3">
            <label for="importProduk" class="form-label"></label>
            <input class="form-control" type="file" name="fileImport" id="importProduk" required="required">
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


@if (session()->has('success'))
  <div class="alert alert-info" role="alert">
    {{ session('success') }}
  </div>
@endif
<div class="row my-auto">
    <div class="col paginate">
        {{ $dataproduk->links() }}
    </div>
    <form action="/produk" class="col pencarian">
        <div class="input-group">
            <button class="btn btn-outline-secondary btn-rv" type="submit"><i class="bi bi-search"></i></button>
            <input type="text" class="form-control" placeholder="Cari berdasarkan Kode atau Nama Produk" name="search">
        </div>
    </form>
</div>
<table class="table table-borderless">
    <tr>
        <th>No</th>
        <th>Kode Produk</th>
        <th>Nama Produk</th>
        <th>Satuan</th>
        <th>Harga Beli</th>
        <th>Harga Jual</th>
        <th>Tindakan</th>
    </tr>
    @foreach($dataproduk as $pr)
	<tr class="align-middle">
		<td>{{$loop->iteration}}</td>
		<td>{{$pr->kodeproduk}}</td>
		<td>{{$pr->namaproduk}}</td>
        <td>{{$pr->satuan}}</td>
        <td>{{$pr->hargabeli}}</td>
        <td>{{$pr->hargajual}}</td>
		<td>
			<form action="/produk/{{ $pr->id }}/edit" method="post" class="d-inline">
                @csrf
                <button class="btn btn-secondary btn-flat" onclick="return confirm('Konfirmasi Ubah ?')">Ubah</button>
            </form>
			<form action="/produk/{{ $pr->id }}/hapus" method="post" class="d-inline">
                @csrf
                <button class="btn btn-outline-secondary btn-flat" onclick="return confirm('Konfirmasi Hapus ?')">Hapus</button>
            </form>
		</td>
	</tr>
	@endforeach
</table>

{{-- <nav aria-label="Page navigation example">
    <ul class="pagination">
      <li class="page-item">
        <a class="page-link" href="#" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
      <li class="page-item"><a class="page-link" href="#">1</a></li>
      <li class="page-item"><a class="page-link" href="#">2</a></li>
      <li class="page-item"><a class="page-link" href="#">3</a></li>
      <li class="page-item">
        <a class="page-link" href="#" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
    </ul>
  </nav> --}}

  {{-- Halaman : {{ $dataproduk->currentPage() }} <br/>
	Jumlah Data : {{ $dataproduk->total() }} <br/>
	Data Per Halaman : {{ $dataproduk->perPage() }} <br/>


	{{ $dataproduk->links() }} --}}

@endsection
