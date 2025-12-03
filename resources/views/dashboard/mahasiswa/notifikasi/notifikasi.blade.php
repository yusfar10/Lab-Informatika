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
    .item-notif { 
      background: #e9ecef; 
      border-radius: 10px; 
      padding: 15px; 
      margin-bottom: 12px; 
      box-shadow: rgba(0,0,0,0.04) 0 3px 6px; 
      cursor:pointer; 
      transition: all 0.2s ease; 
    }
    /* Unread = hijau terang */
    .item-notif.unread { 
      background: #d1f2eb !important; 
      border-left: 4px solid #27ae60;
    }
    /* Read = abu-abu */
    .item-notif:not(.unread) { 
      background: #e9ecef !important; 
      border-left: 4px solid #6c757d;
    }
    .item-notif:hover {
      transform: translateY(-2px);
      box-shadow: rgba(0,0,0,0.1) 0 4px 8px;
    }
    .badge-category { padding: 5px 12px; border-radius: 6px; color: white; font-size:12px; margin-right:10px; }
    /* Indicator untuk read/unread */
    .read-indicator {
      display: inline-block;
      width: 10px;
      height: 10px;
      border-radius: 50%;
      margin-right: 8px;
      vertical-align: middle;
    }
    .read-indicator.unread {
      background: #27ae60;
    }
    .read-indicator.read {
      background: #6c757d;
    }
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

    <div id="notificationList">
      <!-- Notifications will be loaded dynamically here -->
    </div>

    <!-- LOADING STATE -->
    <div id="loadingState" class="text-center my-4" style="display:none;">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <p class="mt-2 text-muted">Memuat notifikasi...</p>
    </div>
  </div>

  <footer class="mt-4">
    Copyright © Kelompok 1 - Manajemen Proyek
  </footer>

  <script src="{{ asset('js/notification-service.js') }}"></script>
  <script src="{{ asset('js/notification-renderer.js') }}"></script>
  <script src="{{ asset('js/notification-page-full.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
