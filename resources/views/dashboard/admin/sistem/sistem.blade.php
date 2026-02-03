<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem & Broadcast</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        html,
        body {
            height: 100%;
        }

        body {
            background: #f0f4f8;
            font-family: 'Poppins', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        #main-wrapper {
            flex: 1;
        }

        .card-custom {
            background: #fff;
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
        }

        .stat-box {
            background: #ffffff;
            padding: 20px;
            border-radius: 14px;
            text-align: center;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        }

        .stat-title {
            color: #777;
            font-size: 14px;
        }

        .stat-value {
            font-size: 26px;
            font-weight: bold;
        }

        .online {
            color: #28a745;
        }

        .error-count {
            color: #EF6C00;
        }

        .footer {
            background: #1f344f;
            color: white;
            padding: 12px;
            text-align: center;
            margin-top: 40px;
        }

        .btn-red {
            background: #d9534f;
            color: white;
        }

        .btn-orange {
            background: #f0ad4e;
            color: white;
        }

        .btn-green {
            background: #5cb85c;
            color: white;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('template-dashboard/style/dash-admin.css') }}">
</head>

<body>

    <!-- NAVBAR -->
    @include('dashboard.nav.nav-admin')

    <!-- CONTENT -->
    <div class="container mt-4 mb-5" id="main-wrapper">

        <h3 class="fw-bold">Pengaturan Sistem & Broadcast</h3>
        <p class="text-secondary">Kirim pengumuman ke semua user</p>

        <!-- STATUS BOX -->
        <div class="row g-3 mb-4">
            <div class="col-lg-4">
                <div class="stat-box">
                    <p class="stat-title">Status Server</p>
                    <p class="stat-value online">Online</p>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="stat-box">
                    <p class="stat-title">Terakhir Backup</p>
                    <p class="stat-value">1 jam lalu</p>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="stat-box">
                    <p class="stat-title">Total Error (24 jam)</p>
                    <p class="stat-value error-count">2</p>
                </div>
            </div>
        </div>

        <!-- BROADCAST FORM -->
        <div class="card-custom mb-4">
            <h5 class="fw-bold mb-3">Broadcast Pengumuman</h5>

            <div class="row mb-3">
                <div class="col-lg-6">
                    <select class="form-select">
                        <option selected>Semua User</option>
                        <option>Dosen</option>
                        <option>Mahasiswa</option>
                    </select>
                </div>
            </div>

            <input type="text" class="form-control mb-3" placeholder="Judul Pengumuman">

            <textarea class="form-control mb-3" rows="4" placeholder="Tulis pesan disini..."></textarea>

            <button class="btn btn-primary">Kirim Sekarang</button>
        </div>

        <!-- HISTORY BROADCAST -->
        <div class="card-custom mb-4">
            <h5 class="fw-bold mb-3">Riwayat Broadcast</h5>

            <!-- Item 1 -->
            <div class="d-flex justify-content-between border rounded p-2 mb-2">
                <div>
                    <strong>Lab 1 tutup besok</strong><br>
                    <small class="text-muted">• 25 User</small>
                </div>
                <span class="text-secondary">2 menit lalu</span>
            </div>

            <!-- Item 2 -->
            <div class="d-flex justify-content-between border rounded p-2">
                <div>
                    <strong>Update Jadwal</strong><br>
                    <small class="text-muted">• gen 1</small>
                </div>
                <span class="text-secondary">1 jam lalu</span>
            </div>
        </div>

        <!-- SYSTEM BUTTONS -->
        <div class="d-flex gap-2">
            <button class="btn btn-green">Backup Database</button>
            <button class="btn btn-orange">Clear Cache</button>
            <button class="btn btn-red">Restart Server</button>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="px-6 py-2 btn btn-outline-danger">
                    Logout
                </button>
            </form>
        </div>

    </div>

    <!-- FOOTER -->
    <div class="footer">
        Copyright © Kelompok 1 - Manajemen Proyek
    </div>

</body>

</html>
