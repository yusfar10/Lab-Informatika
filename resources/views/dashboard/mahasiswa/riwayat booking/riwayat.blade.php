<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Riwayat Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" type="image" href="{{ asset('images/LogoInformatics.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template-dashboard/style/style.css') }}">
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            background-color: #f4f6f9;
            font-family: 'Poppins', sans-serif;
            display: flex;
            flex-direction: column;
            padding-top: 70px;
        }

        main {
            flex: 1;
        }

        .navbar {
            background-color: #1a263e;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            position: fixed;
            /* Memastikan navbar tetap di atas */
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1030;
        }

        .navbar-brand img {
            width: 45px;
            margin-right: 8px;
        }

        .navbar-nav .nav-link {
            color: #fff;
            font-weight: 600;
            margin: 0 8px;
        }

        .navbar-nav .nav-link:hover {
            color: #004aad;
        }

        .content-box {
            background: #fff;
            border-radius: 10px;
            padding: 25px;
            margin-top: 0;
            /* Menghilangkan margin-top ganda */
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        }

        .footer {
            background-color: #22304A;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            margin-top: auto;
            /* Memastikan footer berada di bawah */
        }

        .profile-pic {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid #fff;
            object-fit: cover;
        }

        /* Style untuk Tombol dan Input Pencarian yang Disesuaikan */
        .search-group {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            /* Jarak antara elemen */
        }

        .search-input-wrapper {
            position: relative;
            flex-grow: 1;
            max-width: 350px;
            min-width: 200px;
            /* Batasi lebar kolom Search */
        }

        .search-input-wrapper .form-control {
            border-radius: 5px;
            padding-left: 35px;
            /* Ruang untuk ikon */
        }

        .search-input-wrapper .bi-search {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }

        .filter-select {
            width: 150px;
            min-width: 120px;
            /* Atur lebar dropdown filter */
            border-radius: 5px;
        }

        .btn-check-blue {
            background-color: #0d6efd;
            /* Warna biru Bootstrap primer */
            color: #fff;
            font-weight: 500;
            border-radius: 5px;
            /* Sesuaikan dengan input dan dropdown */
            padding: 8px 20px;
            border: none;
            height: 38px;
            white-space: nowrap;
            /* Sesuaikan tinggi dengan input */
        }

        /* Responsive: Mobile */
        @media (max-width: 768px) {
            .search-group {
                flex-direction: column;
                align-items: stretch;
            }

            .search-input-wrapper {
                max-width: 100%;
            }

            .filter-select {
                width: 100%;
            }

            .btn-check-blue {
                width: 100%;
            }
        }

        /* Style Tabel */
        .badge-status {
            border-radius: 20px;
            color: #fff;
            font-size: 0.75rem;
            /* Dikecilkan sedikit */
            padding: 5px 10px;
            font-weight: 600;
            display: inline-block;
            text-transform: uppercase;
        }

        .table thead th {
            font-weight: 600;
            color: #555;
            background-color: #f8f9fa;
        }

        /* Truncate text untuk kolom Penggunaan Kelas */
        .table td.text-truncate-custom {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            cursor: help;
            position: relative;
        }
        
        /* Responsive: Kurangi max-width di mobile */
        @media (max-width: 768px) {
            .table td.text-truncate-custom {
                max-width: 150px;
            }
        }
    </style>
</head>

<body>

    @include('dashboard.nav.nav-mahasiswa')

    <main class="container my-4">
        <div class="content-box">
            <h4 class="fw-bold mb-4">Booking History</h4>

            <div class="search-group mb-4">
                <div class="search-input-wrapper">
                    <i class="bi bi-search"></i>
                    <input type="text" class="form-control" id="search-riwayat" placeholder="Search">
                </div>

                <input type="date" class="form-control filter-select" id="filter-tanggal-riwayat" style="width: 150px; min-width: 140px;">

                <select id="filter-status-riwayat" class="form-select filter-select">
                    <option value="all">All</option>
                    <option value="aktif">Aktif</option>
                    <option value="completed">Completed</option>
                </select>

                <select id="filter-sort-riwayat" class="form-select filter-select">
                    <option value="newest">Newest</option>
                    <option value="older">Older</option>
                </select>

                <button id="btn-check-riwayat" class="btn btn-check-blue">Check</button>
            </div>

            <div id="loading-riwayat" style="display: none;"></div>


            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Date & Time (Jadwal)</th>
                            <th>Nama Pengguna</th>
                            <th>Ruangan</th>
                            <th>Booking Time</th>
                            <th>Status</th>
                            <th>Penggunaan Kelas</th>
                            <th>Waktu Booking Dibuat</th>
                        </tr>
                    </thead>
                    <tbody id="table-booking">
                        <!-- Data akan diisi oleh JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <footer class="footer">
        Copyright © Kelompok 1 - Manajemen Proyek
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/services/api-service.js"></script>
    <script src="/js/notification.js"></script>
    <script src="/js/riwayat-service.js"></script>
    <script src="/js/riwayat-page.js"></script>

</body>

</html>
