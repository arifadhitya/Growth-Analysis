@extends('layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

    <h1 class="judul-page">Hasil Analisa</h1>

    <div>
    <!-- Tombol import -->
    {{-- <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importDataProduk">
        Import
    </button> --}}
    <!-- Tombol tambah produk -->
    {{-- <a href="/produk/tambah" class="btn btn-primary" role="button">Tambah</a> --}}
    </div>

</div>

<div class="row">
    <div class="col-7">
        @foreach ($rules as $rls)
        <div class="card mb-2 card-analisa">
            <div class="card-body row ">
                <div class="col-3 float my-auto">
                    <div class="row-2 ms-2 fs-3 fw-light">
                        <span class="fw-bold">{{ round((float)$rls[2] * 100 ) . '%' }}</span>
                        {{-- <span class="fw-bold">{{ $rls[3]  . '/' . $rls[4] }} </span> --}}
                        <p class="fs-6 mb-0 txt-gray">Transaksi</p>
                        {{-- {{ $rls[2] }} --}}
                        {{-- @if ($rls[2] > 1)
                        {{ 1 }}
                        @else
                        {{ $rls[2] }}
                        @endif --}}
                    </div>
                </div>
                <div class="col rounded float my-auto">
                    <div class="row">
                        <div class="row fw-light txt-gray">
                            yang membeli
                        </div>
                        <div class="row fw-bold">
                            @foreach ($rls[0] as $r)
                            {{
                            $namaProduk[$r]
                            }} <br>
                            @endforeach
                            {{-- @foreach ($rls[3] as $f)
                                {{ $f }}
                            <br>
                            @endforeach --}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="row fw-light txt-gray">
                            maka membeli
                        </div>
                        <div class="row fw-bold">
                            @foreach ($rls[1] as $r)
                            {{
                            $namaProduk[$r]
                            }}
                            <br>
                            @endforeach
                            {{-- @foreach ($rls[3] as $f)
                                {{ $f }}
                            <br>
                            @endforeach --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="col kanan">
        {{-- <div class="row">
            <div class="col input-group pencarian">
                <button class="btn btn-outline-secondary btn-rv" type="button" id="button-addon1"><i class="bi bi-search"></i></button>
                <input type="text" class="form-control" placeholder="Cari berdasarkan Kode atau Nama Produk" aria-label="Example text with button addon" aria-describedby="button-addon1">
            </div>
        </div> --}}
        <div class="row">
            <span class="txt-gray fw-light">Tanggal transaksi</span>
            <span class="txt-rv">{{ date("d M Y", $newDateFormat1) }} - {{ date("d M Y", $newDateFormat2) }}</span>
        </div>
        <div class="row">
            <div class="col">
                <div class="row">
                    <span class="txt-gray fw-light">Minimum Support</span>
                </div>
                <div class="row">
                    <span class="txt-rv">{{ $minSupp }}</span>
                </div>
            </div>
            <div class="col">
                <div>
                    <span class="txt-gray fw-light">Minimum Confidence</span>
                </div>
                <div>
                    <span class="txt-rv">{{ $minConf }}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="row">
                    <span class="txt-gray fw-light">Aturan Asosiasi</span>
                </div>
                <div class="row">
                    <span class="txt-rv">{{ count($rules) }}</span>
                </div>
            </div>
            <div class="col">
                <div>
                    <span class="txt-gray fw-light">Jumlah Transaksi</span>
                </div>
                <div>
                    <span class="txt-rv">{{ count($transaksiPembelian) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
