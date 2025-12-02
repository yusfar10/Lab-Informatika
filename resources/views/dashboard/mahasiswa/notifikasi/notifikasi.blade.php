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

    <!-- ============================= -->
    <!--   NOTIFICATION LIST (STATIC) -->
    <!-- ============================= -->

    <div id="notificationList">

      <!-- 1 -->
      <div class="item-notif unread">
        <span class="badge-category bg-primary">Booking</span>
        Booking kelas berhasil dibuat.
        <div class="text-muted mt-1" style="font-size:12px;">2025-01-01 09:00</div>
      </div>

      <!-- 2 -->
      <div class="item-notif unread">
        <span class="badge-category bg-success">Pengumuman</span>
        Jadwal kelas telah diperbarui.
        <div class="text-muted mt-1" style="font-size:12px;">2025-01-02 11:20</div>
      </div>

      <!-- 3 -->
      <div class="item-notif unread">
        <span class="badge-category bg-warning">Peringatan</span>
        Booking Anda hampir kadaluarsa.
        <div class="text-muted mt-1" style="font-size:12px;">2025-01-03 07:30</div>
      </div>

      <!-- 4 -->
      <div class="item-notif">
        <span class="badge-category bg-primary">Booking</span>
        Booking diterima oleh admin.
        <div class="text-muted mt-1" style="font-size:12px;">2025-01-04 17:00</div>
      </div>

      <!-- 5 -->
      <div class="item-notif">
        <span class="badge-category bg-danger">Peringatan</span>
        Salah satu ruangan tidak tersedia.
        <div class="text-muted mt-1" style="font-size:12px;">2025-01-05 14:12</div>
      </div>

      <!-- 6 -->
      <div class="item-notif">
        <span class="badge-category bg-success">Pengumuman</span>
        Profil Anda telah diperbarui.
        <div class="text-muted mt-1" style="font-size:12px;">2025-01-06 10:40</div>
      </div>

      <!-- 7 -->
      <div class="item-notif">
        <span class="badge-category bg-primary">Booking</span>
        Pembatalan booking dilakukan admin.
        <div class="text-muted mt-1" style="font-size:12px;">2025-01-07 12:00</div>
      </div>

      <!-- 8 -->
      <div class="item-notif">
        <span class="badge-category bg-success">Pengumuman</span>
        Sistem maintenance pada 10 Januari.
        <div class="text-muted mt-1" style="font-size:12px;">2025-01-08 16:30</div>
      </div>

    </div>

    <!-- LOADING STATE -->
    <div id="loadingState" class="text-center my-4" style="display:none;">
      <div class="spinner-border" role="status"></div>
      <p class="mt-2 text-muted">Memuat notifikasi...</p>
    </div>
  </div>

  <footer class="mt-4">
    Copyright © Kelompok 1 - Manajemen Proyek
  </footer>

  <script src="{{ asset('js/notification-service.js') }}"></script>
  <script src="{{ asset('js/notification-renderer.js') }}"></script>
  <script src="{{ asset('js/notification-page.js') }}"></script>
  <script src="{{ asset('js/notification.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
