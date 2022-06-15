<header class="navbar navbar-dark sticky-top bg-purplex flex-md-nowrap p-0 shadow">
  <a class="navbar-brand py-3 col-md-3 col-lg-2 me-0 px-3" href="#"><b>Growth Analysis</b></a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <!-- <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search"> -->
  <div class="navbar-nav">
    <div class="nav-item text-nowrap">
        @auth
        <a class="nav-link px-3" href="/login">Sign out</a>
        @endauth
    </div>
  </div>
</header>
