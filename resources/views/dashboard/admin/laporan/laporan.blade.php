<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Booking</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        html,
        body {
            height: 100%;
        }

        body {
            background: #f4f7fa;
            font-family: 'Poppins', sans-serif;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        #main-wrapper {
            flex: 1;
        }

        /* CARD / BOX */
        .stat-box {
            background: #ffffff;
            padding: 25px;
            border-radius: 18px;
            text-align: center;
            box-shadow: 0 3px 14px rgba(0, 0, 0, 0.08);
        }

        .stat-title {
            font-size: 14px;
            color: #777;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
        }

        .line-title {
            font-weight: 600;
            margin-top: 40px;
        }

        /* TABEL */
        table {
            background: white;
            border-radius: 12px;
        }

        table thead {
            border-bottom: 2px solid #ddd;
        }

        table td,
        table th {
            padding: 15px;
        }

        .btn-export-csv {
            background: #0d6efd;
            color: white;
        }

        .btn-export-pdf {
            background: #1fae51;
            color: white;
        }

        .footer {
            background: #1f344f;
            padding: 15px;
            text-align: center;
            color: white;
            margin-top: 50px;
        }

        .badge-status {
            background: #1fae51;
            padding: 8px 16px;
            border-radius: 20px;
            color: white;
            font-weight: 600;
        }

        /* --- Gaya untuk Kontainer Tabel --- */
        .table-container {
            padding: 20px;
            background-color: #ffffff;
            /* Latar belakang area di sekitar tabel */
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-top: 20px;
        }

        /* --- Gaya untuk Judul Tabel --- */
        .table-title {
            font-size: 1.5em;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }

        /* --- Gaya Dasar Tabel --- */
        .custom-table {
            width: 100%;
            border-collapse: separate;
            /* Penting untuk border-radius di sel */
            border-spacing: 0;
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            /* Latar belakang putih untuk sel */
            border-radius: 8px;
            /* Sudut membulat pada tabel */
            overflow: hidden;
            /* Penting untuk menjaga sudut yang membulat */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            /* Sedikit bayangan */
        }

        /* --- Gaya Header Tabel --- */
        .custom-table thead tr {
            background-color: #ffffff;
            /* Header juga putih */
            color: #333;
            text-align: left;
            border-bottom: 2px solid #e0e0e0;
        }

        .custom-table th {
            padding: 12px 15px;
            font-weight: 600;
            /* Sedikit lebih tebal dari default */
            border-bottom: 1px solid #e0e0e0;
        }

        /* --- Gaya Isi Tabel --- */
        .custom-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e0e0e0;
            /* Garis pemisah antar baris */
            color: #555;
        }

        .custom-table tbody tr:last-child td {
            border-bottom: none;
            /* Hilangkan garis bawah pada baris terakhir */
        }

        /* --- Gaya Hover Baris (Opsional) --- */
        .custom-table tbody tr:hover {
            background-color: #f0f7ff;
            /* Efek hover ringan */
        }

        /* --- Gaya untuk Badge Status --- */
        .badge-status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            /* Sudut sangat membulat */
            font-size: 0.85em;
            font-weight: bold;
            color: #ffffff;
            text-align: center;
            background-color: #4CAF50;
            /* Hijau */
        }

        /* --- Penyesuaian Sudut Membulat pada Baris Pertama dan Terakhir --- */
        .custom-table thead tr:first-child th:first-child {
            border-top-left-radius: 8px;
        }

        .custom-table thead tr:first-child th:last-child {
            border-top-right-radius: 8px;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('template-dashboard/style/dash-admin.css') }}">
</head>

<body>

    <!-- NAVBAR -->
    @include('dashboard.nav.nav-admin')

    <div class="container mt-4" id="main-wrapper">

        <div class="table-container mb-3">
            <h3 class="fw-bold">Laporan</h3>
            <p class="text-secondary">Data Booking Real-Time</p>
        </div>

        <!-- FILTER -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body d-flex gap-3 align-items-center">
                <select class="form-select border-light-subtle text-secondary" style="max-width: 250px;">
                    <option selected>November</option>
                    <option>Desember</option>
                </select>

                <select class="form-select border-light-subtle text-secondary" style="max-width: 250px;">
                    <option selected>Semua Ruang</option>
                </select>

                <div class="ms-auto d-flex gap-2">
                    <button class="btn btn-primary rounded-pill px-4 shadow-sm"
                        style="font-size: 0.85rem; background-color: #0b5ed7;">
                        Export CSV
                    </button>

                    <button class="btn btn-success rounded-pill px-4 shadow-sm"
                        style="font-size: 0.85rem; background-color: #2d7a3a; border: none;">
                        Export PDF
                    </button>
                </div>
            </div>
        </div>

        <!-- 3 STAT BOX -->
        <div class="row g-3 mb-4">
            <div class="col-lg-4">
                <div class="stat-box">
                    <p class="stat-title">Total Booking</p>
                    <p class="stat-value">127</p>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="stat-box">
                    <p class="stat-title">Ruang Terpopuler</p>
                    <p class="stat-value text-primary">Lab 1</p>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="stat-box">
                    <p class="stat-title">Rata-rata</p>
                    <p class="stat-value text-primary">70%</p>
                </div>
            </div>
        </div>

        <div class="table-container">
            <h5 class="line-title">Grafik</h5>
            <canvas id="chart" class="mt-3"></canvas>
        </div>

        <!-- TABEL -->
        <div class="table-container">
            <div class="table-title">Tabel laporan booking</div>
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Ruang</th>
                        <th>Booking</th>
                        <th>Pengguna</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>11 Nov 2025</td>
                        <td>Lab 1</td>
                        <td>10</td>
                        <td>Yusuf, Fatih dll</td>
                        <td><span class="badge-status">Selesai</span></td>
                    </tr>

                    <tr>
                        <td>12 Nov 2025</td>
                        <td>Lab 2</td>
                        <td>23</td>
                        <td>Revi, Mae dll</td>
                        <td><span class="badge-status">Selesai</span></td>
                    </tr>

                    <tr>
                        <td>13 Nov 2025</td>
                        <td>Lab 2</td>
                        <td>23</td>
                        <td>Lingga, Arif dll</td>
                        <td><span class="badge-status">Selesai</span></td>
                    </tr>

                    <tr>
                        <td>14 Nov 2025</td>
                        <td>Lab 1</td>
                        <td>10</td>
                        <td>Revi, Mae dll</td>
                        <td><span class="badge-status">Selesai</span></td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

    <!-- FOOTER -->
    <div class="footer">
        Copyright © Kelompok 1 – Manajemen Proyek
    </div>

    <script>
        const ctx = document.getElementById('chart');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['1 Nov', '2 Nov', '3 Nov', '4 Nov', '5 Nov', '6 Nov', '7 Nov'],
                datasets: [{
                    data: [10, 30, 55, 40, 20, 30, 10],
                    borderWidth: 3,
                    tension: 0.4
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>

</body>

</html>
