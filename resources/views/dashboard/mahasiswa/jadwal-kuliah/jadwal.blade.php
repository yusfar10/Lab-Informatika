<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jadwal Kuliah</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" type="image" href="{{ asset('images/LogoInformatics.png') }}">
  <link rel="stylesheet" href="{{ asset('template-dashboard/style/style.css') }}">
<style>
        #wrapper{
          flex-grow: 1;
        }
</style>
</head>
<body>
  @include('dashboard.nav.nav-mahasiswa')
    <div id="wrapper">
        Halaman Booking
    </div>
    <!-- FOOTER -->
    <footer>
        Copyright © Kelompok 1 - Manajemen Proyek
    </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>