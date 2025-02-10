<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="false">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm">
                    <a class="opacity-5 text-white" href="javascript:void(0);">Pages</a>
                </li>
                <li class="breadcrumb-item text-sm text-white active" aria-current="page">Aplikasi HRD</li>
            </ol>
            <h6 class="font-weight-bolder text-white mb-0">User </h6>
        </nav>

        <ul class="navbar-nav justify-content-end">
            <li class="nav-item">
                <a class="btn btn-danger" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out-alt"></i> Logout
                </a>
            </li>

            @if (session('impersonate'))
                <a href="{{ route('impersonate.stop') }}" class="btn btn-warning">
                    Stop Impersonation
                </a>
            @endif

            <li class="nav-item d-xl-none ps-3 pe-0 d-flex align-items-center">
                <a href="javascript:void(0);" class="nav-link text-white p-0" id="iconNavbarSidenav">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </a>
            </li>
            <li class="nav-item px-3 d-flex align-items-center">
                <a href="javascript:void(0);" class="nav-link text-white p-0"></a>
                <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
            </li>
        </ul>
    </div>
</nav>