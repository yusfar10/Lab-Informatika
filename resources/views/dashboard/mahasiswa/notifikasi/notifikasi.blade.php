<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Notifikasi</title>
  <link rel="icon" type="image" href="{{ asset('images/LogoInformatics.png') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('template-dashboard/style/style.css') }}">
<style>
        .notif-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: rgba(0,0,0,0.05) 0px 4px 10px;
        }
        .wrapper-judul{
        }
        .wrapper-judul p{
          margin-bottom: 0;
        }
        .wrapper-judul h4{
          margin-bottom: 0;
        }
        .item-notif-judul {
            background: white;
            display: flex;
            align-items: center;
            border-radius: 10px;
            padding: 26px 19px 1px 19px;
            box-shadow: rgba(0,0,0,0.04) 0px 4px 1px;
        }
        .item-notif-option {
            background: white;
            border-radius: 10px;
            padding: 25px 19px;
            margin-bottom: 1px;
            box-shadow: rgba(0,0,0,0.04) 0px 3px 6px;
        }
        .item-notif {
            background: white;
            border-radius: 10px;
            padding: 15px 18px;
            margin-bottom: 12px;
            box-shadow: rgba(0,0,0,0.04) 0px 3px 6px;
        }

        .badge-category {
            background: #d9534f;
            padding: 5px 13px;
            border-radius: 6px;
            color: white;
            font-size: 12px;
            margin-right: 10px;
        }
        #wrapper{
          flex-grow: 1;
        }
</style>
</head>
<body>
  @include('dashboard.nav.nav-mahasiswa')
    <div class="container mt-4" id="wrapper" >
        {{-- <div class="notif-card"> --}}

            <!-- JUDUL -->
            <div class="item-notif-judul mb-4">
              <div class="wrapper-judul ">
                <h4 class="fw-bold">NOTIFIKASI</h4>
                <p class="text-muted mb-4">Semua pemberitahuan</p>
              </div>
            </div>

            <!-- FILTER -->
            <div class="item-notif-option row mb-3 g-1">
                <div class="col-md-4">
                    <select class="form-select">
                        <option selected>Semua Notifikasi</option>
                        <option>Booking</option>
                        <option>Pengumuman</option>
                        <option>Peringatan</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <select class="form-select">
                        <option selected>Semua Status</option>
                        <option>Belum Dibaca</option>
                        <option>Sudah Dibaca</option>
                    </select>
                </div>

                <div class="col-md-4 text-end">
                    <button class="btn btn-primary px-4">Tandai Semua Dibaca</button>
                </div>
            </div>

            <!-- NOTIFIKASI 1 -->
            <div class="item-notif d-flex justify-content-between align-items-start">
                <div>
                    <span class="badge-category">Cori</span>
                    <span class="fw-semibold">Booking Lab 1 10.00 disetujui !</span>
                    <p class="text-muted mb-0">oleh Admin</p>
                </div>

                <div class="text-end">
                    <span class="text-muted small">2 menit lalu</span><br>
                    <a href="#" class="small fw-semibold">Lihat Detail</a>
                </div>
            </div>

            <!-- NOTIFIKASI 2 -->
            <div class="item-notif d-flex justify-content-between align-items-start">
                <div>
                    <span class="badge-category">Cori</span>
                    <span class="fw-semibold">Pengumuman: Lab tutup besok</span>
                    <p class="text-muted mb-0">dari Admin</p>
                </div>

                <div class="text-end">
                    <span class="text-muted small">5 menit lalu</span><br>
                    <a href="#" class="small fw-semibold">Lihat Detail</a>
                </div>
            </div>

            <!-- NOTIFIKASI 3 -->
            <div class="item-notif d-flex justify-content-between align-items-start">
                <div>
                    <span class="fw-semibold">Booking Lab 2 dibatalkan oleh admin</span>
                    <p class="text-muted mb-0">Alasan: Bentrok jadwal</p>
                </div>

                <div class="text-end">
                    <span class="text-muted small">1 jam lalu</span><br>
                    <a href="#" class="small fw-semibold">Lihat Detail</a>
                </div>
            </div>

        </div>
    </div>

    <!-- FOOTER -->
    <footer>
        Copyright © Kelompok 1 - Manajemen Proyek
    </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>