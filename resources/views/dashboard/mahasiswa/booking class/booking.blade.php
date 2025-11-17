<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Laboratorium</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background-color: #f2f4f7; }

        .navbar {
            background-color: #0c2340 !important;
            padding: 14px;
        }
        .navbar a {
            color: white !important;
            margin-right: 18px;
            font-size: 15px;
        }

        .card-left {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-top: 45px;
        }

        .info-box {
            background-color: #e8f3ff;
            border-left: 5px solid #007bff;
            padding: 15px;
            border-radius: 5px;
        }

        .schedule-table{
          border-radius: 9px;
        }
        .schedule-table th {
            background-color: #0c2340;
            color: white;
            font-size: 14px;
        }

        .badge-green {
            background-color: #c4f7c6;
            color: #0f7513;
            padding: 4px 10px;
            border-radius: 6px;
        }

        .badge-red {
            background-color: #ffc9c9;
            color: #b30000;
            padding: 4px 10px;
            border-radius: 6px;
        }
        .padding-tanggal{
          background: #F9F9F9;
          padding: 20px;
          border-radius: 7px;
          box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
          width: 900px;
          margin-left: 1px;
          margin-bottom: 36px
        }
        .head{
          border-radius: 7px;
        }
        .lonceng{
          width: 18px;
        }

        footer {
            background-color: #0c2340;
            color: white;
            padding: 15px;
            text-align: center;
            margin-top: 40px;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid px-4">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="../LogoInformatics.png" width="40" class="me-2">
            </a>

            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#">Booking Class</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Jadwal Kuliah</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Riwayat</a></li>
                    <li class="nav-item">
                        <img src="../user.png" class="rounded-circle" style="width:40px;">
                        <!-- https://i.pravatar.cc/40 -->
                    </li>
                    <li class="nav-item position-relative d-flex align-items-center" style="cursor:pointer; margin-left: 10px;">
                        <img src="../Vector.png" class="lonceng" alt="">

                        <span class="position-absolute top-0 start-100 translate-middle bg-danger text-white rounded-circle "
                              style="font-size: 11px; padding:1px 6px;">
                            3
                        </span>
                    </li>
                  </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- CONTENT -->
    <div class="container-fluid p-4">
        <div class="row">
            
            <!-- FORM BOOKING -->
            <div class="col-md-3">
                <div class="card-left shadow-sm">
                    <h5 class="fw-bold mb-3">Form Booking Laboratorium</h5>

                    <p>Isi form di bawah untuk memesan laboratorium</p>

                    <div class="info-box mb-3">
                        <b>Informasi Penting</b>
                        <p style="font-size: 13px; margin-top: 8px;">
                            Semua pengguna menggunakan sistem SKS.  
                            Durasi dihitung 1 SKS = 50 menit.  
                            Maksimal 4 SKS = 200 menit.
                        </p>
                    </div>

                    <label class="fw-semibold">Pengguna Kelas</label>
                    <input type="text" class="form-control mb-2">

                    <label class="fw-semibold">Penggunaan Kelas</label>
                    <input type="text" class="form-control mb-2">

                    <label class="fw-semibold">Laboratorium</label>
                    <input type="text" class="form-control mb-2">

                    <label class="fw-semibold">Tanggal Booking</label>
                    <input type="date" class="form-control mb-2">

                    <label class="fw-semibold">Jam Mulai</label>
                    <input type="time" class="form-control mb-2">

                    <label class="fw-semibold">SKS (max 4)</label>
                    <input type="number" min="1" max="4" class="form-control mb-3">

                    <div class="p-2 bg-light rounded mb-3">
                        <b>Perkiraan selesai:</b> 07:50  
                        <br>Durasi: 50 menit
                    </div>

                    <button class="btn btn-primary w-100">Konfirmasi Booking</button>
                </div>
            </div>

            <!-- JADWAL -->
            <div class="col-md-9">
                <h4 class="fw-bold mb-3">Jadwal Laboratorium</h4>

                <div class="row padding-tanggal">
                    <div class="col-md-4">
                        <label>Tanggal</label>
                        <input type="date" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label>Pilih Laboratorium</label>
                        <input type="text" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="d-block">Tampilkan</label>
                        <input type="checkbox"> Hanya slot tersedia
                    </div>
                </div>

                <!-- TABLE -->
                <div class="table-responsive shadow-sm head">
                    <table class="table table-bordered schedule-table">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Senin</th>
                                <th>Selasa</th>
                                <th>Rabu</th>
                                <th>Kamis</th>
                                <th>Jum'at</th>
                            </tr>
                        </thead>

                        <tbody>
                            <!-- ROW TEMPLATE -->
                            <tr>
                                <td>07:00 - 07:30</td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-red">Penuh</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                            </tr>
                            <tr>
                                <td>07:30 - 08:00</td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-red">Penuh</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                            </tr>
                            <tr>
                                <td>07:30 - 08:00</td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-red">Penuh</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                            </tr>
                            <tr>
                                <td>07:30 - 08:00</td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-red">Penuh</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                            </tr>
                            <tr>
                                <td>07:30 - 08:00</td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-red">Penuh</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                            </tr>
                            <tr>
                                <td>07:30 - 08:00</td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-red">Penuh</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                            </tr>
                            <tr>
                                <td>07:30 - 08:00</td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-red">Penuh</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                            </tr>
                            <tr>
                                <td>07:30 - 08:00</td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-red">Penuh</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                            </tr>
                            <tr>
                                <td>07:30 - 08:00</td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-red">Penuh</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                            </tr>
                            <tr>
                                <td>07:30 - 08:00</td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-red">Penuh</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                            </tr>
                            <tr>
                                <td>07:30 - 08:00</td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-red">Penuh</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                            </tr>
                            <tr>
                                <td>07:30 - 08:00</td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-red">Penuh</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                            </tr>
                            <tr>
                                <td>07:30 - 08:00</td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-red">Penuh</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                            </tr>
                            <tr>
                                <td>07:30 - 08:00</td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-red">Penuh</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                            </tr>
                            <tr>
                                <td>07:30 - 08:00</td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-red">Penuh</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                            </tr>
                            <tr>
                                <td>07:30 - 08:00</td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-red">Penuh</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                            </tr>
                            <tr>
                                <td>07:30 - 08:00</td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-red">Penuh</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                                <td><span class="badge-green">Tersedia</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <footer>
        Copyright © Kelompok 1 - Manajemen Proyek
    </footer>

</body>
</html>
