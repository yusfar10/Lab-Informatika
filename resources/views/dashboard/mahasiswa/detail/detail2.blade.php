<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Lab Komputer</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template-dashboard/style/style.css') }}">

    <style>
        .hero-img {
            width: 100%;
            height: 450px;
            object-fit: cover;
            border-radius: 12px;
        }

        .info-box {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: rgba(0,0,0,0.05) 0px 4px 10px;
        }

        .fasilitas-item {
            border: 1px solid #ddd;
            padding: 8px 18px;
            border-radius: 8px;
            margin-right: 10px;
            margin-bottom: 10px;
            display: inline-block;
            font-size: 14px;
        }

        .badge-booking {
            background: #0AAD5C;
            padding: 6px 26px;
            border-radius: 20px;
            color: white;
            font-size: 14px;
            position: absolute;
            right: 30px;
            top: 380px;
        }
        .lab2{
          position: absolute;
          right: 950px;
          color: #ffffff;
          top: 480px;
        }
        .fasilitas-box{
          margin-left: 69px;
          padding-top: 18px;
        }
        .container1{
          margin-left: 50px;
          justify-content: center;
          display: flex;
        }
        .box-fasilitas{
          width:500px;
          margin-left: 5px;
        }

        .gap-fasilitas{
          text-align: center;
          padding-top: 7px;
          padding-bottom: 7px;
          justify-content: start;
          margin-left: 53px; 
        }
        .box-right{
          width: 558px;
        }
        
    </style>
</head>

<body>

    <!-- NAVBAR -->
    @include('dashboard.nav.nav-mahasiswa')

    <!-- HEADER IMAGE -->
    <div class="container mt-4 position-relative">
        <img src="{{ asset('template-dashboard/img/lab2.jpg') }}" class="hero-img" alt="Lab">
        <span class="badge-booking">Booking</span>
    </div>

    <!-- TITLE -->
    <div class="container mt-3">
        <h3 class="fw-bold lab2">Lab Komputer 2</h3>
    </div>

    <!-- INFO BOX -->
    <div class="container mt-3">
        <div class="info-box d-flex justify-content-between text-center">

            <div class="col-3">
                <p class="fw-semibold mb-1">Kategori :</p>
                <span>Lab 2</span>
            </div>

            <div class="col-3">
                <p class="fw-semibold mb-1">Gedung :</p>
                <span>Siber</span>
            </div>

            <div class="col-3">
                <p class="fw-semibold mb-1">Lantai :</p>
                <span>7</span>
            </div>

            <div class="col-3">
                <p class="fw-semibold mb-1">Kapasitas :</p>
                <span>30 Komputer</span>
            </div>

        </div>
    </div>

    <!-- FASILITAS + KONTAK -->
<!-- FASILITAS -->
    <h5 h5 class="fw-bold mb-3 fasilitas-box">Fasilitas :</h5>

    <div class="row g-3 container container1">
        <!-- BOX FASILITAS -->
        <div class="col-md-6">
            <div class="p-3 box-fasilitas rounded shadow-sm" style="background:#ffffff;">
                <div class="d-flex flex-wrap gap-3 gap-fasilitas">
                    <button class="btn btn-outline-secondary btn-sm p-4">AC</button>
                    <button class="btn btn-outline-secondary btn-sm px-5">Wifi</button>
                    <button class="btn btn-outline-secondary btn-sm px-4">Smart Board</button>
                    <button class="btn btn-outline-secondary btn-sm px-4">PC</button>
                    <button class="btn btn-outline-secondary btn-sm px-4">Meja</button>
                    <button class="btn btn-outline-secondary btn-sm px-4">Kursi</button>
                </div>
            </div>
        </div>

        <!-- BOX KONTAK PJ -->
        <div class="col-md-6">
            <div class="p-3 rounded shadow-sm box-right" style="background:#ffffff;">
                <h6 class="fw-bold mb-2">Kontak Penanggung Jawab</h6>

                <p class="m-0">Ahmad</p>
                <p class="m-0">Office Boy Gedung Siber</p>

                <div class="d-flex justify-content-between mt-2">
                    <span>Nomor Hp</span>
                    <span class="fw-bold">0123 4567 8910</span>
                </div>

                <div class="d-flex justify-content-between">
                    <span>Shift Kerja</span>
                    <span class="fw-bold">07.00 - 17.00</span>
                </div>
            </div>
        </div>
    </div>


    <!-- FOOTER -->
    <footer>
        Copyright by Kelompok 1 - Manajemen Proyek
    </footer>

</body>
</html>
