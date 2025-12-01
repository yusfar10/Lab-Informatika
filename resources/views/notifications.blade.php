<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script type="module" src="/js/notification.js" defer></script>

    <style>
        body { background: #f8f9fa; }
        .border-left-info { border-left: 3px solid #0d6efd; }
    </style>
</head>
<body>

<div class="container mt-4">

    <!-- LOADING -->
    <div id="notif-loading" class="text-center py-3">
        <div class="spinner-border"></div>
        <p>Memuat notifikasi...</p>
    </div>

    <!-- NOTIFICATION CONTAINER -->
    <div id="notif-container"></div>

    <!-- EMPTY STATE -->
    <p id="notif-empty" class="text-center text-muted d-none">
        Tidak ada notifikasi.
    </p>

</div>
<script type="module" src="/js/notification.js" defer></script>


</body>
</html>
