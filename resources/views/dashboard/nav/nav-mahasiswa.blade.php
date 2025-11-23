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
        <!-- DROPDOWN PROFIL -->
            <li class="nav-item dropdown">
                <a href="#" class="d-flex align-items-center" id="profileDropdown"
                   data-bs-toggle="dropdown" aria-expanded="false" style="cursor:pointer;">
                    <img src="{{ asset('template-dashboard/img/user.png') }}"
                         class="rounded-circle ms-3" width="40" alt="User">
                </a>

                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                    <li>
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                           Logout
                        </a>
                        
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        <a href="{{ route('mahasiswa.notifikasi') }}">
          <li class="nav-item"><img src="{{ asset('template-dashboard/img/Vector.png') }}" class="notifikasi" width="40"></li>
        </a>
      </ul>
    </div>
  </nav>
