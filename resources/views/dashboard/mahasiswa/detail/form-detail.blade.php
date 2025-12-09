<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kelas</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template-dashboard/style/style.css') }}">

    <style>
        .card {
            border-radius: 12px;
        }

        label {
            font-size: 14px;
            font-weight: 600;
        }
        .textc{
          padding-top: -9px;
        }
    </style>
</head>

<body>
@include('dashboard.nav.nav-mahasiswa')

<div class="container mt-4">

    <!-- Judul Halaman -->
    <h3 class="fw-bold">Detail Kelas</h3>
    <p class="text-muted">Informasi mengenai kelas</p>

    <!-- Card Form Detail -->
    <div class="card shadow-sm border-0 mt-3">
        <div class="card-body">

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Nama Kelas</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" value="Kelas A" disabled>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Jumlah Mahasiswa</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" value="25" disabled>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Ruangan</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" value="Lab 1" disabled>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Tanggal Dibuat</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" value="25 Nov 2025" disabled>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Waktu Mulai</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" value="09.00" disabled>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Waktu Selesai</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" value="11.00" disabled>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Dibuat oleh</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" value="Admin" disabled>
                </div>
            </div>

            <div class="row mb-4">
                <label class="col-sm-3 col-form-label">Status</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" value="Aktif" disabled>
                </div>
            </div>

        </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="card shadow-sm border-0 mt-3">
      <div class="d-flex mt-4 gap-2 card-body textc">
          <a href="#" class="btn btn-success px-4">Edit</a>
          <a href="#" class="btn btn-danger px-4">Hapus</a>
          <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-light px-4 border">Kembali</a>
      </div>
    </div>

</div>

<!-- Footer -->
<footer class="mt-5">
  <p>Copyright by Kelompok 1 - Manajemen Proyek</p>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
