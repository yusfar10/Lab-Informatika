<nav class="navbar navbar-fixed navbar-expand-lg px-4 ">
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="{{ asset('template-dashboard/img/LogoInformatics.png') }}" alt="Logo">
    </a>
    <div class="ms-auto">
      <ul class="navbar-nav d-flex align-items-center">
        <li class="nav-item"><a class="nav-link" href="{{ route('mahasiswa.dashboard') }}">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('mahasiswa.booking-kelas') }}">Booking Class</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('mahasiswa.jadwal-kuliah') }}">Jadwal Kuliah</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('mahasiswa.riwayat') }}">Riwayat</a></li>
        <li class="nav-item"><img src="{{ asset('template-dashboard/img/user.png') }}" class="rounded-circle ms-3" width="40"></li>
      </ul>
    </div>
  </nav>