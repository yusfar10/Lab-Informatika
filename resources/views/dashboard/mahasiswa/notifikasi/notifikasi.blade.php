<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Notifikasi</title>
  <link rel="icon" type="image" href="{{ asset('images/LogoInformatics.png') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('template-dashboard/style/style.css') }}">
  <style>
    .item-notif { background: white; border-radius: 10px; padding: 15px; margin-bottom: 12px; box-shadow: rgba(0,0,0,0.04) 0 3px 6px; cursor:pointer; }
    .item-notif.unread { background: #eef3ff; }
    .badge-category { padding: 5px 12px; border-radius: 6px; color: white; font-size:12px; margin-right:10px; }
  </style>
</head>
<body>
  @include('dashboard.nav.nav-mahasiswa')

  <div class="container mt-4" id="wrapper">
    <div class="item-notif-judul mb-4">
      <h4 class="fw-bold">NOTIFIKASI</h4>
      <p class="text-muted">Semua pemberitahuan</p>
    </div>

    <div class="item-notif-option row mb-3 g-1">
      <div class="col-md-4">
        <select id="filterCategory" class="form-select">
          <option value="">Semua Notifikasi</option>
          <option value="booking">Booking</option>
          <option value="pengumuman">Pengumuman</option>
          <option value="peringatan">Peringatan</option>
        </select>
      </div>

      <div class="col-md-4">
        <select id="filterStatus" class="form-select">
          <option value="">Semua Status</option>
          <option value="unread">Belum Dibaca</option>
          <option value="read">Sudah Dibaca</option>
        </select>
      </div>

      <div class="col-md-4 text-end">
        <button id="markAllBtn" class="btn btn-primary px-4">Tandai Semua Dibaca</button>
      </div>
    </div>

    <div id="notificationList"></div>

    <div id="loadingState" class="text-center my-4" style="display:none;">
      <div class="spinner-border" role="status"></div>
      <p class="mt-2 text-muted">Memuat notifikasi...</p>
    </div>
  </div>

  <footer class="mt-4">
    Copyright © Kelompok 1 - Manajemen Proyek
  </footer>

  <script src="/js/notification-service.js"></script>
  <script src="/js/notification-page.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
