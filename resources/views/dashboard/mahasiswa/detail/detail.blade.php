<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Lab Komputer</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template-dashboard/style/style.css') }}">

    <style>
        body { background: #e6eaed; }

        .hero-img {
            width: 100%;
            height: 420px;
            object-fit: cover;
            border-radius: 12px;
        }

        .badge-booking {
            position: absolute;
            top: 435px;
            right: 25px;
            background: #0AAD5C;
            padding: 6px 26px;
            border-radius: 20px;
            color: #fff;
            font-size: 14px;
        }

        .info-box {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: rgba(0,0,0,0.05) 0px 4px 10px;
        }

        .btn-fasilitas {
            border-radius: 8px;
            padding: 7px 18px;
            font-size: 14px;
        }

        footer {
            margin-top: 40px;
            padding: 20px;
            text-align: center;
            background: #1f2b39;
            color: #fff;
            border-radius: 8px 8px 0 0;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    @include('dashboard.nav.nav-mahasiswa')

    <!-- HEADER IMAGE -->
    <div class="container mt-4 position-relative">
        <img src="{{ asset('template-dashboard/img/lab1.jpg') }}" class="hero-img" alt="Lab">

        <span class="badge-booking">Booking</span>
    </div>

    <!-- TITLE -->
    <div class="container mt-3">
        <h3 class="fw-bold">Lab Komputer 1</h3>
    </div>

    <!-- INFO BOX -->
    <div class="container mt-3">
        <div class="info-box row text-center">

            <div class="col-md-3">
                <p class="fw-semibold mb-1">Kategori :</p>
                <span>Lab 1</span>
            </div>

            <div class="col-md-3">
                <p class="fw-semibold mb-1">Gedung :</p>
                <span>Siber</span>
            </div>

            <div class="col-md-3">
                <p class="fw-semibold mb-1">Lantai :</p>
                <span>7</span>
            </div>

            <div class="col-md-3">
                <p class="fw-semibold mb-1">Kapasitas :</p>
                <span>30 Komputer</span>
            </div>

        </div>
    </div>

    <!-- FASILITAS -->
    <div class="container mt-4">
        <h5 class="fw-bold mb-3">Fasilitas :</h5>

        <div class="row g-3">
            <!-- BOX FASILITAS -->
            <div class="col-md-6">
                <div class="p-3 rounded shadow-sm" style="background:#ffffff;">
                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-outline-secondary btn-sm btn-fasilitas">AC</button>
                        <button class="btn btn-outline-secondary btn-sm btn-fasilitas">Wifi</button>
                        <button class="btn btn-outline-secondary btn-sm btn-fasilitas">Smart Board</button>
                        <button class="btn btn-outline-secondary btn-sm btn-fasilitas">PC</button>
                        <button class="btn btn-outline-secondary btn-sm btn-fasilitas">Meja</button>
                        <button class="btn btn-outline-secondary btn-sm btn-fasilitas">Kursi</button>
                    </div>
                </div>
            </div>

            <!-- BOX KONTAK -->
            <div class="col-md-6">
                <div class="p-3 rounded shadow-sm" style="background:#ffffff;">
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
    </div>

    <!-- FOOTER -->
    <footer>
        Copyright by Kelompok 1 - Manajemen Proyek
    </footer>

</body>
</html>
