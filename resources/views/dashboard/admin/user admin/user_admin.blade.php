<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Admin - Admin Panel</title>

  <!-- ✅ Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">


  <style>
    html,body{
            height: 100%;
    }
    body {
      background-color: #f4f6f9;
      font-family: 'Poppins', sans-serif;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    /* ✅ Kotak konten */
    .content-box {
      background: white;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    /* ✅ Kartu user */
    .user-card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.08);
      padding: 20px;
      margin-bottom: 20px;
    }
    .serch-ua{
      padding-right: 20px;
    }

    .footer {
    background-color: #1a2a40;
    color: white;
    text-align: center;
    padding: 15px;
  }

    .btn-action {
      margin-right: 8px;
    }
    #wrapper {
      flex: 1;
    }
    
    .navbar {
    display: flex;
    align-items: center;
    background: white;
}
  </style>
  <link rel="stylesheet" href="{{ asset('template-dashboard/style/dash-admin.css') }}">
</head>
<body>

  <!-- ✅ NAVBAR -->
@include('dashboard.nav.nav-admin')

  <!-- ✅ KONTEN UTAMA -->
  <div class="container mt-4 p-4 " id="wrapper" >
    <div class=" border-2 ">
      <div class="content-box p-3 mb-3">
        <h4 class="fw-bold mb-1">User</h4>
        <p>Kelola akun kosma - aktifkan, reset, nonaktifkan</p>
      </div>

      <!-- ✅ Kolom search dan tombol tambah -->
      <div class="d-flex justify-content-between gap-3 mb-4">
        <div class="input-group serch-ua d-flex" style="max-width: 960px;">
          <input type="text" class="form-control serch-ua" placeholder="Search">
          <span class="input-group-text"><i class="bi bi-search"></i></span>
        </div>

        <button class="btn btn-primary">+ Tambah User</button>
      </div>

      <!-- ✅ Kartu user -->
      <div class="row">
        <div class="col-md-6">
          <div class="user-card">
            <h6>Nama Kosma : Yusuf Alim Romadon</h6>
            <p class="mb-1">NIM : <span class="text-primary">2388010006</span></p>
            <p class="mb-2 text-success">Status Aktif • Terakhir Login : 2 jam lalu</p>
            <button class="btn btn-danger btn-action">Nonaktifkan</button>
            <button class="btn btn-primary ">Edit</button>
            <button class="btn btn-danger">Hapus</button>
          </div>
        </div>

        <div class="col-md-6">
          <div class="user-card">
            <h6>Nama Kosma : Yusuf Alim Romadon</h6>
            <p class="mb-1">NIM : <span class="text-primary">2388010006</span></p>
            <p class="mb-2 text-success">Status Nonaktif • Terakhir Login : 2 jam lalu</p>
            <button class="btn btn-success btn-action">Aktifkan</button>
            <button class="btn btn-primary ">Edit</button>
            <button class="btn btn-danger">Hapus</button>
          </div>
        </div>
      </div>

      <!-- ✅ Tombol export -->
      <div class="text-end mt-3">
        <button class="btn btn-primary">Export Daftar User (CSV)</button>
      </div>
    </div>
  </div>

  <!-- ✅ FOOTER -->
  <div class="footer">
    Copyright © Kelompok 1 - Manajemen Proyek
  </div>

  <!-- ✅ Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.js"></script>
</body>
</html>
