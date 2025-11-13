<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Kelola Ruang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Poppins', sans-serif;
        }
        .navbar {
            background-color: #22304A;
        }
        .navbar-brand img {
            width: 40px;
            height: 40px;
        }
        .navbar-nav .nav-link {
            color: #fff !important;
            font-weight: 500;
            margin-right: 20px;
        }
        .navbar-nav .nav-link.active {
            color: #00AEEF !important;
        }
        .content-box {
            background: #fff;
            border-radius: 10px;
            padding: 25px;
            margin-top: 25px;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        }
        .room-card {
            border-radius: 12px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.08);
            background: #fff;
            padding: 20px;
        }
        .footer {
            background-color: #22304A;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            margin-top: 40px;
        }
        .btn-custom {
            border-radius: 20px;
            font-weight: 500;
        }
        .btn-blue {
            background-color: #007bff;
            color: white;
        }
        .btn-green {
            background-color: #28a745;
            color: white;
        }
        .btn-red {
            background-color: #dc3545;
            color: white;
        }
        .btn-purple {
            background-color: #6f42c1;
            color: white;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="/images/logo.png" alt="Logo">
                <span class="text-white ms-2 fw-bold">ADMIN PANEL</span>
            </a>
            <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#">Ruang</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">User</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Booking</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Laporan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Sistem</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container my-4">
        <div class="content-box">
            <h5 class="fw-bold">Kelola Ruang</h5>
            <p>Tambah, edit, atau nonaktifkan ruang - update langsung ke user</p>
            <button class="btn btn-primary btn-custom mb-4">+ Tambah Ruang Baru</button>

            <div class="row g-3">
                <!-- Card Ruang 1 -->
                <div class="col-md-6">
                    <div class="room-card">
                        <h6 class="fw-bold mb-1">Lab 1</h6>
                        <p class="mb-1">30 PC • Gedung Siber - Lantai 7</p>
                        <p>Status: <span class="text-success fw-semibold">Aktif</span> • Total Booking: 10</p>
                        <div class="d-flex gap-2 mt-2">
                            <button class="btn btn-blue btn-sm btn-custom px-3">Edit</button>
                            <button class="btn btn-red btn-sm btn-custom px-3">Nonaktifkan</button>
                            <button class="btn btn-purple btn-sm btn-custom px-3">Lihat Jadwal</button>
                        </div>
                    </div>
                </div>

                <!-- Card Ruang 2 -->
                <div class="col-md-6">
                    <div class="room-card">
                        <h6 class="fw-bold mb-1">Lab 2</h6>
                        <p class="mb-1">30 PC • Gedung Siber - Lantai 7</p>
                        <p>Status: <span class="text-danger fw-semibold">Nonaktif</span> • Total Booking: 10</p>
                        <div class="d-flex gap-2 mt-2">
                            <button class="btn btn-blue btn-sm btn-custom px-3">Edit</button>
                            <button class="btn btn-green btn-sm btn-custom px-3">Aktifkan</button>
                            <button class="btn btn-purple btn-sm btn-custom px-3">Lihat Jadwal</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p class="mb-0">Copyright © Kelompok 1 - Manajemen Proyek</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
