<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Laboratorium</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image" href="{{ asset('template-dashboard/img/LogoInformatics.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100..900&display=swap" rel="stylesheet">
    <style>
        body { 
            background-color: #f2f4f7;
            padding-top: 70px; 
            font-family: 'Poppins', sans-serif;
        }

        .navbar {
            background-color: #1a263e !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .navbar-brand img {
            height: 45px;
            margin-right: 8px;
        }
        .navbar-nav .nav-link {
            font-weight: 600;
            color: #fff;
            margin: 0 8px;
        }
        .navbar-nav .nav-link:hover {
            color: #004aad;
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

        footer {
            background-color: #0c2340;
            color: white;
            padding: 15px;
            text-align: center;
            margin-top: 40px;
        }
        .schedule-table th {
            background-color: #0d2a4d;
            color: white;
            text-align: center;
        }

        .schedule-table td {
            text-align: center;
            vertical-align: middle;
            padding: 10px;
        }

        .badge-green {
            background: #a8efb4;
            color: #0d6d24;
            font-weight: 600;
            padding: 5px 15px;
            border-radius: 6px;
            cursor: pointer;
            display: inline-block;
        }

        .badge-red {
            background: #ffb6b6;
            color: #8a0000;
            font-weight: 600;
            padding: 5px 15px;
            border-radius: 6px;
            cursor: pointer;
            display: inline-block;
        }

        .schedule-table {
            border: 1px solid #ddd;
            border-radius: 6px;
            overflow: hidden;
        }
    </style>

</head>

<body>
    @include('dashboard.nav.nav-mahasiswa')

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
                        <select class="form-select">
                            <option selected disabled>Pilih Laboratorium</option>
                            <option value="lab1">Lab Komputer 1</option>
                            <option value="lab2">Lab Komputer 2</option>
                        </select>
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
                            <tr>
                                <td>07:00 - 07:30</td>
                                <td><span class="badge-green toggle-slot">Tersedia</span></td>
                                <td><span class="badge-green toggle-slot">Tersedia</span></td>
                                <td><span class="badge-red toggle-slot">Penuh</span></td>
                                <td><span class="badge-green toggle-slot">Tersedia</span></td>
                                <td><span class="badge-green toggle-slot">Tersedia</span></td>
                            </tr>

                            <tr>
                                <td>07:30 - 08:00</td>
                                <td><span class="badge-green toggle-slot">Tersedia</span></td>
                                <td><span class="badge-green toggle-slot">Tersedia</span></td>
                                <td><span class="badge-red toggle-slot">Penuh</span></td>
                                <td><span class="badge-green toggle-slot">Tersedia</span></td>
                                <td><span class="badge-green toggle-slot">Tersedia</span></td>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.querySelectorAll('.toggle-slot').forEach(slot => {
        slot.addEventListener('click', function () {
            if (this.classList.contains('badge-green')) {
                this.classList.remove('badge-green');
                this.classList.add('badge-red');
                this.textContent = "Penuh";
            } else {
                this.classList.remove('badge-red');
                this.classList.add('badge-green');
                this.textContent = "Tersedia";
            }
        });
    });
    </script>



</body>
</html>
