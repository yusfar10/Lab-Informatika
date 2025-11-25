<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image" href="{{ asset('images/LogoInformatics.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template-dashboard/style/style.css') }}">
    <style>
        html, body {
            height: 100%;
        }
        body {
            background-color: #f4f6f9;
            font-family: 'Poppins', sans-serif;
            display: flex;
            flex-direction: column;
            padding-top:70px;
            
        }
        main {
            flex: 1;
        }
        .navbar {
            background-color: #1a263e;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
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
            margin-top: 25px;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        }
        .footer {
            background-color: #22304A;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            margin-top: 53px;
        }
        .profile-pic {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid #fff;
            object-fit: cover;
        }
        .btn-check-blue {
            background-color: #007bff;
            color: #fff;
            font-weight: 500;
            border-radius: 20px;
            padding: 5px 20px;
        }
        .badge-status {
            border-radius: 20px;
            color: #fff;
            font-size: 0.85rem;
            padding: 8px 10px;
            font-weight: 500;
        }
        .bg-blue { background-color: #007bff; }
        .bg-green { background-color: #28a745; }
        .bg-red { background-color: #dc3545; }
        .bg-warning { background-color: #ffc107; color: #000; }
        .main1{
            height: 600px;
        }
        .lonceng{
          width: 18px;
        }
        .navbar-fixed {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 9999;
        }
        .notifikasi{
            width: 24px;
            margin-left: 18px;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    @include('dashboard.nav.nav-mahasiswa')

    <!-- Main Content -->
    <div class="container my-4" id="wrapper">
        <div class="content-box">
            <h5 class="fw-bold">Booking History</h5>
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Search">
                </div>
                <div class="col-md-2">
                    <select class="form-select">
                        <option>All</option>
                        <option>Aktif</option>
                        <option>Nonaktif</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-check-blue w-100">Check</button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Date & Time</th>
                            <th>Nama Pengguna</th>
                            <th>Ruangan</th>
                            <th>Booking Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2025/11/05 20:44:10</td>
                            <td>Nama Kosma - 3A</td>
                            <td>Lab 2</td>
                            <td>3 SKS</td>
                            <td><span class="badge-status bg-blue">Ms Pemb</span></td>
                        </tr>
                        <tr>
                            <td>2025/11/05 20:44:10</td>
                            <td>HIMAFOR - EDT</td>
                            <td>Lab 1</td>
                            <td>3 SKS</td>
                            <td><span class="badge-status bg-red">Report Rusak</span></td>
                        </tr>
                        <tr>
                            <td>2025/11/05 20:44:10</td>
                            <td>Nama Kosma - 3A</td>
                            <td>Lab 1</td>
                            <td>4 SKS</td>
                            <td class="badge-status bg-green"><span>Mk APSI</span></td>
                        </tr>
                        <tr>
                            <td>2025/11/05 20:44:10</td>
                            <td>Nama Kosma - 3A</td>
                            <td>Lab 1</td>
                            <td>1 SKS</td>
                            <td><span class="badge-status bg-blue">Mk SPK</span></td>
                        </tr>
                        <tr>
                            <td>2025/11/05 20:44:10</td>
                            <td>Nama Kosma - 3A</td>
                            <td>Lab 1</td>
                            <td>3 SKS</td>
                            <td><span class="badge-status bg-blue">Mk NP</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        Copyright © Kelompok 1 - Manajemen Proyek
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
