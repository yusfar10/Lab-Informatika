<nav class="navbar navbar-fixed navbar-expand-lg px-4">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="{{ asset('template-dashboard/img/LogoInformatics.png') }}" class="ukuranlogo me-2" alt="Logo">
            <strong>ADMIN PANEL</strong>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <div class="ms-auto">
                <ul class="navbar-nav d-flex align-items-center">
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.ruang') }}">Ruang</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.user') }}">User</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.booking') }}">Booking</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.laporan') }}">Laporan</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.sistem') }}">Sistem</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>