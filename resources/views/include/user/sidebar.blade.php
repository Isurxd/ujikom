<style>
.sidenav {
    height: 100vh;
    width: 100px;
    overflow-y: auto;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
}

.sidenav-header {
     /* overflow-y:visible; */
    padding: 1rem;
    display: flex;
    align-items: center;
}

.sidenav-header .navbar-brand {
    display: flex;
    align-items: center;
    font-size: 1rem;
}

.sidenav-header .navbar-brand-img {
    height: 32px;
    width: auto;
    margin-right: 0.5rem;
}

.nav-section {
    margin: 0.5rem 0;
}

.nav-section-title {
    padding: 0.5rem 1rem;
    font-size: 0.7rem;
    text-transform: uppercase;
    font-weight: 700;
    color: #8898aa;
    letter-spacing: 0.5px;
    margin-bottom: 0.25rem;
}


.nav-link {
    padding: 0.5rem 0.75rem;
    display: flex;
    align-items: center;
    color: #67748e;
    border-radius: 0.375rem;
    transition: all 0.2s ease;
    min-height: 2.5rem;
}

.nav-link:hover {
    background-color: #f6f9fc;
    color: #5e72e4;
}

.nav-item.active .nav-link {
    background-color: #5e72e4;
    color: white;
    box-shadow: 0 2px 4px rgba(94, 114, 228, 0.2);
}

.nav-item.active .nav-link i {
    color: white !important;
}

.nav-link-icon {
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 0.375rem;
    margin-right: 0.5rem;
}

.nav-link-icon i {
    font-size: 0.875rem;
}

.nav-link-text {
    font-size: 0.813rem;
    font-weight: 500;
}

.horizontal-divider {
    margin: 0.5rem 0;
    opacity: 0.2;
}
</style>

<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl fixed-start ms-4" id="sidenav-main">
    <!-- Sidebar Header -->
    <div class="sidenav-header">
        <a class="navbar-brand" href="{{ url('user/dashboard') }}">
            <img src="{{ asset('user/assets/img/logo-ct-dark.png') }}" class="navbar-brand-img" alt="logo">
            <span class="font-weight-bold">Aplikasi HRD</span>
        </a>
        <button class="btn btn-link position-absolute end-0 top-0 d-xl-none" id="iconSidenav">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <hr class="horizontal-divider">

    <!-- Sidebar Content -->
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav" style="overflow-y: hidden" >
            <!-- Main Navigation -->
            <li class="nav-item {{ request()->is('user/dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('user/dashboard') }}">
                    <div class="nav-link-icon">
                        <i class="ni ni-tv-2 text-primary"></i>
                    </div>
                    <span class="nav-link-text">Dashboard</span>
                </a>
            </li>

            <!-- Data Tables Section -->
            <div class="nav-section">
                <div class="nav-section-title">Data Tables</div>
                
                <li class="nav-item {{ request()->is('user/absensi') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('user/absensi') }}">
                        <div class="nav-link-icon">
                            <i class="ni ni-calendar-grid-58 text-warning"></i>
                        </div>
                        <span class="nav-link-text">Absensi</span>
                    </a>
                </li>

                <li class="nav-item {{ request()->is('user/penggajian') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('user/penggajian') }}">
                        <div class="nav-link-icon">
                            <i class="ni ni-credit-card text-success"></i>
                        </div>
                        <span class="nav-link-text">Penggajian</span>
                    </a>
                </li>

                <li class="nav-item {{ request()->is('user/cuti') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('user/cuti') }}">
                        <div class="nav-link-icon">
                            <i class="ni ni-calendar-grid-58 text-danger"></i>
                        </div>
                        <span class="nav-link-text">Cuti</span>
                    </a>
                </li>

                <li class="nav-item {{ request()->is('user/berkas') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('user/berkas') }}">
                        <div class="nav-link-icon">
                            <i class="ni ni-folder-17 text-info"></i>
                        </div>
                        <span class="nav-link-text">Berkas</span>
                    </a>
                </li>
            </div>

            <!-- Account Section -->
            <div class="nav-section">
                <div class="nav-section-title">Account</div>
                
                <li class="nav-item {{ request()->is('user/profile') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('user/profile') }}">
                        <div class="nav-link-icon">
                            <i class="ni ni-single-02 text-dark"></i>
                        </div>
                        <span class="nav-link-text">Profile</span>
                    </a>
                </li>
            </div>
        </ul>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</aside>