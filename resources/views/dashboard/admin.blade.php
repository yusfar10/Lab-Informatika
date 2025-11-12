<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Booking Lab Informatika</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template-dashboard/style/dash-admin.css') }}">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg px-4">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="{{ asset('template-dashboard/img/logo.png') }} "class="ukuranlogo" alt="Logo">
            <strong>ADMIN PANEL</strong>
        </a>
        <div class="ms-auto">
            <ul class="navbar-nav d-flex align-items-center">
                <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Ruang</a></li>
                <li class="nav-item"><a class="nav-link" href="#">User</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Boking</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Laporan</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Sistem</a></li>
            </ul>
        </div>
    </nav>

    <!-- Konten -->
    <div class="container py-4">

        <!-- Header -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="d-block justify-content-between align-items-center mb-3 pt-5 pb-4">
                <h5 class="fw-bold mb-0 ps-5 selamat">Selamat Datang, Kosma!</h5>
                <small class="text-muted ps-5 fs-5">Sistem berjalan normal - terakhir back up: 2 jam lalu</small>
            </div>
        </div>

        <!-- Statistik -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm text-center p-3">
                    <h6 class="text-muted mb-1">Total Peminjaman</h6>
                    <h3 class="fw-bold text-primary">127</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm text-center p-3">
                    <h6 class="text-muted mb-2">Kelas Paling Banyak Booking</h6>
                    <h5 class="fw-bold text-primary mb-3">Lab Informatika 2</h5>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm text-center p-3">
                    <h6 class="text-muted mb-1">Jumlah Peminjaman Bulan Ini</h6>
                    <h3 class="fw-bold text-primary">18</h3>
                </div>
            </div>
        </div>

        <!-- Kelola Ruang -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-2 d-flex justify-content-between align-items-center">
                <h6 class="fw-semibold mb-0 f24 p-1">Kelola Ruang</h6>
                <button class="btn btn-sm btn-primary">+ Tambah Ruang</button>
            </div>
            <div class="card-body">
                <div class="mb-2 p-2 border rounded bg-light">
                    <div class="ps-3">
                        <strong>Lab 1</strong><br>
                        <small class="opacity-50">30 PC - Gedung Siber - Lantai 7</small>
                    </div>
                </div>
                <div class="p-2 border rounded bg-light">
                    <div class="ps-3">
                        <strong>Lab 2</strong><br>
                        <small class="opacity-50">30 PC - Gedung Siber - Lantai 7</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kelola User -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-2 d-flex justify-content-between align-items-center">
                <h6 class="fw-semibold mb-0 f24 p-1">Kelola User</h6>
                <button class="btn btn-sm btn-primary">+ Tambah User</button>
            </div>
            <div class="card-body">
                <input type="text" class="form-control mb-3" placeholder="Cari Nama / NIM">
                <div class="d-flex justify-content-between align-items-center border rounded p-2 bg-light">
                    <span>Yusuf - Gen 1 - Kosma</span>
                    <a href="#" class="text-decoration-none warna-reset">Reset Password</a>
                </div>
            </div>
        </div>

        <!-- Log Sistem -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-2">
                <h6 class="fw-semibold mb-0 f24 p-1">Log Sistem (Real-Time)</h6>
            </div>
            <div class="card-body small text-muted p-4">
                <p>Admin ubah kapasitas Lab 101 - 30</p>
                <p>User Fatih booking slot 08:00 Lab 101</p>
                <p class="text-danger">Gagal login. 3x dari IP 192.168.1.100</p>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="d-flex mt-3 flex-wrap gap-3">
            <button class="btn btn-primary btn1">Export Booking CSV</button>
            <button class="btn btn-success btn1">Backup Database</button>
            <button class="btn btn-warning btn1">Broadcast Pengumuman</button>
            <button class="btn btn-danger btn1">Reset Cache</button>
        </div>

    </div>

    <!-- Footer -->
    <footer class="text-center mt-4 py-3">
        Copyright by Kelompok 1 - Manajemen Proyek
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
