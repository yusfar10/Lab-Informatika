<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Informacis Lab</title>

  <link rel="icon" type="image" href="{{ asset('images/LogoInformatics.png') }}">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('template-dashboard/style/style.css') }}">

</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-fixed navbar-expand-lg px-4 ">
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="{{ asset('template-dashboard/img/LogoInformatics.png') }}" alt="Logo">
    </a>
    <div class="ms-auto">
      <ul class="navbar-nav d-flex align-items-center">
        <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('mahasiswa.booking-kelas') }}">Booking Class</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('mahasiswa.jadwal-kuliah') }}">Jadwal Kuliah</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('mahasiswa.riwayat') }}">Riwayat</a></li>
        <li class="nav-item"><img src="{{ asset('template-dashboard/img/user.png') }}" class="rounded-circle ms-3" width="40"></li>
      </ul>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="container mt-4">

    <div class="hero">
      <h4>WEBSITE BOOKING ROOM INFORMATICS CLASS!</h4>
      <p>Please Booking yang tertib ya!</p>
    </div>

    <!-- Statistic Cards -->
    <div class="row stats text-center mt-4 g-3">
      <div class="col-md-4">
        <div class="card p-3">
          <p>Total Peminjaman</p>
          <h2>127</h2>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card p-3">
          <p>Kelas Paling Banyak Booking</p>
          <h2 class="highlight">Lab Informatika 2</h2>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card p-3">
          <p>Jumlah Peminjaman Bulan Ini</p>
          <h2>18</h2>
        </div>
      </div>
    </div>

    <!-- Filter -->
    <div class="filter mt-4">
      <form class="row g-2 justify-content-center align-items-center">
        <div class="col-md-3">
          <input type="date" class="form-control">
        </div>
        <div class="col-md-3">
          <input type="date" class="form-control">
        </div>
        <div class="col-md-3">
          <select class="form-select">
            <option selected>-- Pilih Lab --</option>
            <option>Lab Komputer 1</option>
            <option>Lab Komputer 2</option>
          </select>
        </div>
        <div class="col-md-2">
          <button type="button" class="btn btn-primary w-100">Check</button>
        </div>
      </form>
    </div>

    <div class="location mt-3">
      Gedung Cyber UIN SSC Lt 7, Jl. Perjuangan No.1, Karyamulya, Kec. Kesambi, Kota Cirebon, Jawa Barat 45135
    </div>

    <!-- Content Grid -->
    <div class="row mt-4 g-3">
      <!-- Left: Lab List -->
      <div class="col-lg-8">
        <div class="card-custom p-4 mb-3">
          <div class="box-lab d-flex align-items-center">
            <img src="{{ asset('template-dashboard/img/lab1.jpg') }}" class="lab-img me-3 " alt="">
            <div class="pemisah-box">
              <p class="mb-1 fw-semibold">Lab Komputer 1</p>
              <p class="mb-1 small">Kapasitas : 30 Komputer<br>Khusus : Mahasiswa Prodi Informatika<br>Lokasi : Gedung Siber<br>Lantai : 7</p>
              <button class="btn btn-primary btn-sm">View Detail</button>
            </div>
          </div>
        </div>
        <div class="card-custom p-4">
          <div class="box-lab d-flex align-items-center">
            <img src="{{ asset('template-dashboard/img/lab2.jpg') }}" class="lab-img me-3" alt="">
            <div class="pemisah-box">
              <p class="mb-1 fw-semibold">Lab Komputer 1</p>
              <p class="mb-1 small">Kapasitas : 30 Komputer<br>Kh khusus : Mahasiswa Prodi Informatika<br>Lokasi : Gedung Siber<br>Lantai : 7</p>
              <button class="btn btn-primary btn-sm">View Detail</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Right: Latest Booking -->
      <!-- <div class="col-md-4">
        <div class="latest">
          <h5>LATEST BOOKING ROOM!</h5>
          <div class="latest-card">
            <h6>Lab Komputer 1</h6>
            <p>09.00 - 10.00<br>Pembelajaran MK Pak Saluki<br><span>oleh: Kosma 5A</span></p>
            <small>Dipesan 5 menit yang lalu</small>
          </div>
          <div class="latest-card">
            <h6>Lab Komputer 2</h6>
            <p>10.00 - 11.00<br>Pembelajaran MK Pak Saluki<br><span>oleh: Kosma 5A</span></p>
            <small>Dipesan 37 menit yang lalu</small>
          </div>
          <div class="latest-card">
            <h6>Lab Komputer 1</h6>
            <p>13.00 - 15.30<br>Izin mau pakai buat MK Alpro 2 ya kk<br><span>oleh: Kosma 5A</span></p>
            <small>Dipesan 1 jam yang lalu</small>
          </div>
        </div>
      </div> -->
      <div class="col-lg-4">
        <div class="card-custom p-3">
          <h6 class="card-header-custom mb-3">LATEST BOOKING ROOM!</h6>

          <div class="latest-box">
            <p class="fw-semibold mb-0">Lab Komputer 1</p>
            <p class="latest-time">09.00 - 10.00</p>
            <p class="mb-0 small">Pembelajaran MK Pak Saluki<br>oleh: Kosma 5A</p>
            <span class="badge badge-time mt-1">Dipesan 5 menit yang lalu</span>
          </div>

          <div class="latest-box">
            <p class="fw-semibold mb-0">Lab Komputer 2</p>
            <p class="latest-time">10.00 - 11.00</p>
            <p class="mb-0 small">Pembelajaran MK Pak Saluki<br>oleh: Kosma 5A</p>
            <span class="badge badge-time mt-1">Dipesan 37 menit yang lalu</span>
          </div>

          <div class="latest-box">
            <p class="fw-semibold mb-0">Lab Komputer 1</p>
            <p class="latest-time">13.00 - 15.30</p>
            <p class="mb-0 small">Izin mau pakai buat MK Alpro 2 ya kk<br>oleh: Kosma 5A</p>
            <span class="badge badge-time mt-1">Dipesan 5 jam yang lalu</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <footer class="mt-5">
    <p>Copyright by Kelompok 1 - Manajemen Proyek</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
