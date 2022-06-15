@extends('layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

    <h1 class="h2">Tambah Transaksi</h1>

</div>
    <!-- Modal Input -->
        <!-- Formnya -->
        <form action="/transaksi" method="POST" accept-charset="UTF-8" enctype="multipart/form-data" >
        @csrf
            <div class="mb-3 {{ $errors->has('kodetransaksi') ? ' has-error' : '' }}">
                <label for="kodetransaksi" class="form-label">Kode Transaksi</label>
                <input type="text" class="form-control @error('kodetransaksi') is-invalid @enderror" id="kodetransaksi" name="kodetransaksi" required value="{{ old('kodetransaksi') }}">
            @error('kodetransaksi')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
            </div>
            <div class="mb-3" {{ $errors->has('operator') ? ' has-error' : '' }}>
                <label for="operator" class="form-label">Operator</label>
                <input type="text" class="form-control @error('operator') is-invalid @enderror" id="operator" name="operator" value="{{ old('operator') }}">
                @error('operator')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-3" {{ $errors->has('totalbayar') ? ' has-error' : '' }}>
                <label for="totalbayar" class="form-label">Total Bayar</label>
                <input type="text" class="form-control @error('totalbayar') is-invalid @enderror" id="totalbayar" name="totalbayar" value="{{ old('totalbayar') }}">
                @error('totalbayar')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-3" {{ $errors->has('tanggaltransaksi') ? ' has-error' : '' }}>
                <label for="tanggaltransaksi" class="form-label">Tanggal Transaksi</label>
                <input type="text" class="form-control @error('tanggaltransaksi') is-invalid @enderror datepicker" id="tanggaltransaksi" name="tanggaltransaksi" value="{{ old('tanggaltransaksi') }}">
                @error('tanggaltransaksi')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="row">
                <label class="form-label">Belanjaan</label>
            </div>
            <div id="container">
                <div class="row" id="tambah">
                    <div class="mb-3 col" {{ $errors->has('namaproduk') ? ' has-error' : '' }}>
                        <input type="text" class="form-control @error('namaproduk') is-invalid @enderror" id="namaproduk" name="namaproduk[]" required value="{{ old('namaproduk') }}" placeholder="Kode Produk">
                        @error('namaproduk')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3 col" {{ $errors->has('jumlahproduk') ? ' has-error' : '' }}>
                        <input type="number" class="form-control @error('jumlahproduk') is-invalid @enderror" id="jumlahproduk" name="jumlahproduk[]" required value="{{ old('jumlahproduk') }}" placeholder="Jumlah">
                        @error('jumlahproduk')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col">
                        <button type="button" class="form-control btn btn-danger btnDel">Hapus</button>
                    </div>
                </div>
            </div>
            <div>

            </div>
            <div class=" row">
                <div class="col mb-3">
                    <button type="button" id="btnAdd" class="form-control btn btn-info">Tambah</button>
                </div>
            </div>
            <a href="/transaksi" class="btn btn-secondary" role="button">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>

        <script>
            let lastForm;

            // CheckForm
            const checkForm = () => {
                let node = document.querySelectorAll('.btnDel');
                console.log(node.length);
                if(node.length <= 1){
                    lastForm = document.querySelector('.btnDel');
                    lastForm.disabled = true;
                }  else {
                    lastForm.disabled = false;
                }
            }

            // Delete Btn
            const deleteForm = (e) => {
                e.path[2].remove();
                checkForm();
            }

            checkForm();

            // For Delete Btn
            let FirstbtnDel = document.querySelector('.btnDel');
            FirstbtnDel.addEventListener('click', deleteForm);

            // For Clone
            document.querySelector('#btnAdd').addEventListener('click',  function() {
            let base = document.querySelector('#tambah');
            let clone = base.cloneNode(true);

            let cloneDelBtn = clone.querySelector('.btnDel');
            cloneDelBtn.disabled = false;
            cloneDelBtn.addEventListener('click', deleteForm)

            document.querySelector('#container').appendChild(clone)

            checkForm();

            });
        </script>

@endsection
