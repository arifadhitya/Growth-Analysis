@extends('layouts.main')

@section('container')

@if($errors->any())
<script type='text/javascript'>alert({{ $errors->first() }});</script>"</h4>
@endif

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="judul-page text-align-start">
        Selamat Datang,<br>
        {{ auth()->user()->namapegawai }}
    </h1>
</div>

<div class="widget">
    <a href="https://time.is/Kendari,_North_Kalimantan" id="time_is_link" rel="nofollow" style="font-size:36px;color:#548459; text-decoration:none">Waktu di Kendari:</a>
    <span id="Kendari__North_Kalimantan_z42b" style="font-size:36px;color:#548459"></span>
    <script src="//widget.time.is/id.js"></script>
    <script>
    time_is_widget.init({Kendari__North_Kalimantan_z42b:{template:"TIME<br>DATE", date_format:"dayname, dnum monthname year"}});
    </script>
</div>

@endsection
