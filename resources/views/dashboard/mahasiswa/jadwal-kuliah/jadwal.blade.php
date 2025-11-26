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
        #wrapper {
            flex-grow: 1;
        }

        .section-box {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            margin-bottom: 2px;
        }

        .title-big {
            font-size: 28px;
            font-weight: 700;
            text-align: center;
        }

        .subtitle {
            font-size: 14px;
            text-align: center;
            margin-top: 5px;
            color: #666;
        }
         .box {
            background: white;
            padding: 20px;
            border-radius: 10px;
        }
        .search-box {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding-left: 15px;
            height: 45px;
        }
        .search-icon {
            position: absolute;
            right: 15px;
            top: 12px;
            font-size: 18px;
            color: #666;
        }
        .semester-card {
            background: #ffffff;
            padding: 22px 0;
            text-align: center;
            border-radius: 10px;
            font-weight: 600;
            color: #333;
            cursor: pointer;
            border: 1px solid #dcdde1;
            transition: 0.2s;
        }
        .semester-card:hover {
            background: #e0e4ec;
        }
        .section-title {
            padding: 15px;
            font-size: 17px;
            font-weight: 600;
        }
        .btn-blue {
            background: #0b63ce;
            color: white;
            font-weight: 500;
            letter-spacing: 3px;
            padding: 12px;
            width: 100%;
            border-radius: 10px;
            border: none;
            margin-top: 20px;
        }
        select, input[type="date"] {
            height: 45px;
            border-radius: 8px !important;
        }
    </style>
</head>

<body>
    @include('dashboard.nav.nav-mahasiswa')
        <div class="container py-4" id="wrapper">

            <!-- Header -->
            <div class="section-box">
                <div class="title-big">WEBSITE BOOKING ROOM INFORMATICS CLASS!</div>
                <div class="subtitle">Please Booking yang tertib ya!</div>
            </div>
            <div class="container py-4">

                <!-- Search -->
            <div class="mb-3 position-relative">
                <input type="text" class="form-control search-box" placeholder="Search">
                    <i class="search-icon bi bi-search"></i>
            </div>

                <!-- Semester Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="semester-card">Semester 1</div>
                </div>
                <div class="col-md-4">
                    <div class="semester-card">Semester 3</div>
                </div>
                <div class="col-md-4">
                    <div class="semester-card">Semester 5</div>
                </div>
            </div>

                <!-- Filter Box -->
                <div class="box">

                    <div class="section-title">Perkuliahan</div>
                    <hr style="margin-top:-5px;">

                    <div class="row g-3 mt-1">

                        <div class="col-md-6">
                            <label class="form-label">Jenis Anggota</label>
                            <select class="form-select">
                                <option>Mahasiswa</option>
                                <option>Dosen</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Kategori Perkuliahan</label>
                            <select class="form-select">
                                <option>Teori</option>
                                <option>Praktikum</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal</label>
                            <input type="date" class="form-control">
                        </div>

                        <div class="col-md-6 d-grid">
                            <label class="form-label">&nbsp;</label>
                            <button class="btn border">ATUR PERKULIAHAN</button>
                        </div>

                    </div>

                    <button class="btn-blue">C A R I</button>

                </div>

            </div>


        </div>
    <!-- FOOTER -->
    <footer>
        Copyright © Kelompok 1 - Manajemen Proyek
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
