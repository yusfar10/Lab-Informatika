<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Kuliah</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/LogoInformatics.png') }}">
    <link rel="stylesheet" href="{{ asset('template-dashboard/style/style.css') }}">

    <style>
        /* KOTAK CONTENT */
        .content-box {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .title-big {
            font-size: 28px;
            font-weight: 700;
            text-align: center;
        }

        .subtitle {
            font-size: 14px;
            text-align: center;
            margin-top: 5px;
            color: #666;
        }

        select {
            height: 45px;
            border-radius: 8px !important;
        }

        .jadwal-table th {
            font-weight: 600;
            background: #f8f9fa;
        }

        .baris {
            min-width: 1240px;
        }
    </style>
</head>

<body>
    @include('dashboard.nav.nav-mahasiswa')

    <div class="container py-4">

        <!-- HEADER -->
        <div class="content-box text-center">
            <div class="title-big">WEBSITE BOOKING ROOM INFORMATICS CLASS!</div>
            <div class="subtitle">Please Booking yang tertib ya!</div>
        </div>

        <!-- JADWAL PERKULIAHAN BOX -->
        <div class="content-box">

            <h5 class="text-center fw-bold mb-3">Jadwal Perkuliahan</h5>

            <!-- DROPDOWN FILTERS -->
            <div class="row g-3 d-block">

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Pilih Tipe Semester :</label>
                    <select class="form-select baris">
                        <option selected>Ganjil</option>
                        <option>Genap</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Pilih Semester :</label>
                    <select class="form-select baris">
                        <option selected>Semester 1</option>
                        <option>Semester 2</option>
                        <option>Semester 3</option>
                        <option>Semester 4</option>
                        <option>Semester 5</option>
                        <option>Semester 6</option>
                        <option>Semester 7</option>
                        <option>Semester 8</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Pilih Kelas :</label>
                    <select class="form-select baris">
                        <option selected>Kelas A</option>
                        <option>Kelas B</option>
                        <option>Kelas C</option>
                    </select>
                </div>

            </div>

            <!-- TABEL JADWAL -->
            <div class="table-responsive mt-4">
                <table class="table table-bordered text-center align-middle jadwal-table">
                    <thead>
                        <tr>
                            <th>Hari</th>
                            <th>Waktu</th>
                            <th>Mata Kuliah</th>
                            <th>Dosen</th>
                            <th>Ruang</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Senin</td>
                            <td>08.00–10.00</td>
                            <td>Pembo</td>
                            <td>Pak Firdaus</td>
                            <td>Lab 1</td>
                        </tr>
                        <tr>
                            <td>Senin</td>
                            <td>10.30–12.50</td>
                            <td>APSI</td>
                            <td>Pak Suhardi</td>
                            <td>Lab 1</td>
                        </tr>
                        <tr>
                            <td>Selasa</td>
                            <td>07.30–10.00</td>
                            <td>MP</td>
                            <td>Bu Gina</td>
                            <td>Lab 2</td>
                        </tr>
                        <tr>
                            <td>Rabu</td>
                            <td>13.30–15.45</td>
                            <td>AWD</td>
                            <td>Pak Saluky</td>
                            <td>Lab 1</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

    </div>

    <footer>
        Copyright © Kelompok 1 - Manajemen Proyek
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
