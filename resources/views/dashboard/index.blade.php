@extends('layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

    <h5>

    </h5>
    <h1 class="h2">
        Selamat Datang,<br>
        {{ auth()->user()->namapegawai }}
    </h1>

    <div>


    </div>

</div>

@endsection
