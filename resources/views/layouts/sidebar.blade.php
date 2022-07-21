<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar sticky-top">
    <div class="container-sidebar">
        <div class="navbar-name">
            <img src="/img/logo1-putih.svg" alt="">
        </div>
        <div class="position-sticky pt-3">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/dashboard">
                    <div class="row justify-content-start">
                        <div class="col-1"><i class="bi bi-grid-fill"></i></div>
                        <div class="col">Dashboard</div>
                    </div>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/produk">
                    <div class="row justify-content-start">
                        <div class="col-1"><i class="bi bi-clipboard2-fill"></i></div>
                        <div class="col">Data Produk</div>
                    </div>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/transaksi">
                    <div class="row justify-content-start">
                        <div class="col-1"><i class="bi bi-clipboard2-fill"></i></div>
                        <div class="col">Data Transaksi</div>
                    </div>
                </a>
              </li>
              @if (auth()->user()->is_kepalatoko == 1)
              <li class="nav-item">
                <a class="nav-link" href="/analisis">
                <div class="row justify-content-start">
                    <div class="col-1"><i class="bi bi-bar-chart-fill"></i></div>
                    <div class="col">Asosiasi Penjualan</div>
                </div>
                </a>
              </li>
              @endif
              <li class="nav-item">
                <a class="nav-link" href="/staf">
                    <div class="row justify-content-start">
                        <div class="col-1"><i class="bi bi-clipboard2-fill"></i></div>
                        <div class="col">Data Staf</div>
                    </div>
                </a>
              </li>
            </ul>
        </div>
        @auth
        {{-- <li class="nav-item dropdown"> --}}
            <div class="row profile-bot bottom-0">
                <div class="col">
                    {{ auth()->user()->namapegawai }}
                </div>
                <div class="logout mt-1">
                    <form action="/logout" method="post">
                        @csrf
                        <button type="submit" class="row logout">
                            <div class="col-1"><i class="bi bi-box-arrow-left"></i></div>
                            <div class="col">Keluar</div>
                        </button>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>
