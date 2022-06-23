@extends('layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

    <h1 class="h2">Overview</h1>

    <div>
    <!-- Tombol import -->
    {{-- <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importDataProduk">
        Import
    </button> --}}
    <!-- Tombol tambah produk -->
    {{-- <a href="/produk/tambah" class="btn btn-primary" role="button">Tambah</a> --}}
    </div>

</div>

@foreach ($rules as $rls)

<div class="card w-50">
    <div class="card-body row ">
            <div class="col-3 rounded float my-auto">
                <div class="row-2  fs-3 fw-bold">
                    {{ round((float)$rls[2] * 100 ) . '%' }}
                </div>
            </div>
            <div class="col rounded float my-auto">
                <div class="row">
                    @foreach ($rls[0] as $r)
                    {{ $namaProduk[$r] }}
                    @endforeach
                </div>
                <div class="row">
                    {{ $rls[1] }}
                </div>
            </div>
    </div>
  </div>

@endforeach


@endsection
