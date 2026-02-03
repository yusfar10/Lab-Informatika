<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Real-Time</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        html,
        body {
            height: 100%;
        }

        body {
            background: #f0f4f8;
            font-family: 'Poppins', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        #main-wrapper {
            flex: 1;
        }

        .card-custom {
            border-radius: 16px;
            padding: 20px;
            background: #ffffff;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
        }

        .btn-red {
            background: #d9534f;
            color: white;
        }

        .btn-blue {
            background: #0275d8;
            color: white;
        }

        .badge-time {
            color: #04bb38;
            padding: 1px 2px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
        }

        .footer {
            background: #1f344f;
            color: white;
            padding: 12px;
            text-align: center;
            margin-top: 40px;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('template-dashboard/style/dash-admin.css') }}">
</head>

<body>

    <!-- NAVBAR -->
    @include('dashboard.nav.nav-admin')

    <!-- CONTENT -->
    <div class="container mt-4" id="main-wrapper">
        <div class="card-custom mb-4">
            <h2 class="fw-bold">Booking Real-Time</h2>
            <p class="text-secondary">User Booking langsung update</p>
        </div>

        <!-- FILTERS -->
        <div class="row g-3 mb-4">
            <div class="col-lg-4">
                <select class="form-select">
                    <option selected>Semua Ruang</option>
                    <option>Lab 1</option>
                    <option>Lab 2</option>
                    <option>Lab 3</option>
                </select>
            </div>

            <div class="col-lg-4">
                <input type="date" class="form-control">
            </div>

            <div class="col-lg-4">
                <button class="btn btn-primary w-100">Cari</button>
            </div>
        </div>

        <!-- BOOKING LIST -->
        <div class="row g-4">

            <!-- CARD 1 -->
            <div class="col-lg-6">
                <div class="card-custom">
                    <h5>Lab 1 • 10.00 - 13.00</h5>
                    <p class="mb-1 fw-semibold">Yusuf gen 1 - Kosma</p>
                    <span class="badge-time">Dibooking 2 menit lalu</span>

                    <div class="d-flex gap-2 mt-3">
                        <button class="btn btn-red">Batalkan</button>
                        <button class="btn btn-blue">Detail</button>
                    </div>
                </div>
            </div>

            <!-- CARD 2 -->
            <div class="col-lg-6">
                <div class="card-custom">
                    <h5>Lab 1 • 13.00 - 15.00</h5>
                    <p class="mb-1 fw-semibold">Fatih gen 2 - Kosma</p>
                    <span class="badge-time">Dibooking 2 menit lalu</span>

                    <div class="d-flex gap-2 mt-3">
                        <button class="btn btn-red">Batalkan</button>
                        <button class="btn btn-blue">Detail</button>
                    </div>
                </div>
            </div>

        </div>

        <!-- EXPORT BUTTON -->
        <div class="mt-4 text-end">
            <button class="btn btn-primary btn-lg">Export CSV</button>
        </div>

    </div>

    <!-- FOOTER -->
    <div class="footer">
        Copyright © Kelompok 1 - Manajemen Proyek
    </div>

</body>

</html>
