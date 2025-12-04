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
    /* Smooth transition untuk notification list */
    #notificationList {
      transition: opacity 0.3s ease;
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
        <button id="deleteAllBtn" class="btn btn-danger px-4">Hapus Semua Pesan</button>
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

  <!-- Modal Konfirmasi Hapus Semua -->
  <div class="modal fade" id="deleteAllModal" tabindex="-1" aria-labelledby="deleteAllModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteAllModalLabel">Konfirmasi Hapus</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Apakah Anda yakin ingin menghapus semua notifikasi?</p>
          <p class="text-danger"><strong>Tindakan ini tidak dapat dibatalkan.</strong></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-danger" id="confirmDeleteAllBtn">Hapus Semua</button>
        </div>
      </div>
    </div>
  </div>

  <footer class="mt-4">
    Copyright © Kelompok 1 - Manajemen Proyek
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/notification-service.js') }}"></script>
  <script src="{{ asset('js/notification-renderer.js') }}"></script>
  <script src="{{ asset('js/notification-page-full.js') }}"></script>

</body>
</html>
