<nav class="navbar navbar-fixed navbar-expand-lg px-4">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="{{ asset('template-dashboard/img/LogoInformatics.png') }} "class="ukuranlogo" alt="Logo">
            <strong>ADMIN PANEL</strong>
        </a>
        <div class="ms-auto">
            <ul class="navbar-nav d-flex align-items-center">
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.ruang') }}">Ruang</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.user') }}">User</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.booking') }}">Boking</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.laporan') }}">Laporan</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.sistem') }}">Sistem</a></li>
            </ul>
        </div>
</nav>