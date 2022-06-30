<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Signin Template · Bootstrap v5.1</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/sign-in/">



    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Favicons -->
<link rel="apple-touch-icon" href="/docs/5.1/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
<link rel="icon" href="/docs/5.1/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
<link rel="icon" href="/docs/5.1/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
<link rel="manifest" href="/docs/5.1/assets/img/favicons/manifest.json">
<link rel="mask-icon" href="/docs/5.1/assets/img/favicons/safari-pinned-tab.svg" color="#7952b3">
<link rel="icon" href="/docs/5.1/assets/img/favicons/favicon.ico">
<meta name="theme-color" content="#7952b3">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>


    <!-- Custom styles for this template -->
    <link href="/css/signin.css" rel="stylesheet">
  </head>
  <body class="text-center">




<main class="form-signup">
  @if(session()->has('success'))
    <div class="alert alert-success alert-dismissable fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <div class=" justify-content-center">
    <form action="/daftar" method="post">
        @csrf
      <!-- <img class="mb-4" src="/docs/5.1/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
      <h1 class="h3 mb-3 fw-normal">Daftar Pengguna</h1>
      @if(session()->has('loginError'))
      <div class="alert alert-danger alert-dismissable fade show" role="alert">
          {{ session('loginError') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
      <div class="form-floating">
          <input type="text" class="form-control" name="kodepegawai" id="kodepegawai" placeholder="Kode Pegawai" required value="{{ old('kodepegawai') }}">
          <label for="kodepegawai">Kode Pegawai</label>
      </div>
      <div class="form-floating">
          <input type="text" class="form-control" name="namapegawai" id="namapegawai" placeholder="Nama Lengkap" required value="{{ old('namapegawai') }}">
          <label for="kodepegawai">Nama Lengkap</label>
      </div>
      <div class="form-floating">
        <input type="text" class="form-control" name="username" id="username" placeholder="Username" required value="{{ old('username') }}">
        <label for="username">Username</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" placeholder="Kata Sandi" name="password" id="password" required>
        <label for="password">Kata Sandi</label>
      </div>
  </div>


    {{-- <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me"> Remember me
      </label>
    </div> --}}
    <button class="w-100 btn btn-lg btn-primary mt-3" type="submit">Daftar</button>
  </form>
  <p class="mt-5 mb-3 text-muted">&copy; 2022 - @arifadhitya</p>
</main>



  </body>
</html>
