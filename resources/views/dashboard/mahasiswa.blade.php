<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Informatics Lab</title>

    <link rel="icon" type="image" href="{{ asset('images/LogoInformatics.png') }}">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template-dashboard/style/style.css') }}">

</head>

<body>

    <!-- Navbar -->
    {{-- <nav class="navbar navbar-fixed navbar-expand-lg px-4 ">
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="{{ asset('template-dashboard/img/LogoInformatics.png') }}" alt="Logo">
    </a>
    <div class="ms-auto">
      <ul class="navbar-nav d-flex align-items-center">
        <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('mahasiswa.booking-kelas') }}">Booking Class</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('mahasiswa.jadwal-kuliah') }}">Jadwal Kuliah</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('mahasiswa.riwayat') }}">Riwayat</a></li>
        <li class="nav-item"><img src="{{ asset('template-dashboard/img/user.png') }}" class="rounded-circle ms-3" width="40"></li>
      </ul>
    </div>
  </nav> --}}
    @include('dashboard.nav.nav-mahasiswa')

    <!-- Main Content -->
    <div class="container mt-4">

        <div class="hero">
            <h4>WEBSITE BOOKING ROOM INFORMATICS CLASS!</h4>
            <p>Please Booking yang tertib ya!</p>
        </div>

        <!-- Statistic Cards -->
        <div class="row stats text-center mt-4 g-3">
            <div class="col-md-4">
                <div class="card p-3 root-banner">
                    <p class="text-banner">Total Peminjaman</p>
                    <h2 class="highlight" id="totalPeminjaman">-</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <p class="text-banner">Kelas Paling Banyak Booking</p>
                    <h2 class="highlight" id="kelasTerbanyak">-</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <p class="text-banner">Jumlah Peminjaman Bulan Ini</p>
                    <h2 class="highlight" id="peminjamanBulanIni">-</h2>
                </div>
            </div>
        </div>

        <!-- Filter -->
        <div class="filter mt-4">
            <form class="row g-2 justify-content-center align-items-center">
                <div class="keterangan-text">
                    <p class="gap-keterangan">Dari Tanggal : </p>
                    <p class="gap-keterangan">Sampai Tanggal : </p>
                    <p class="gap-keterangan">Ruang Lab : </p>
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control">
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control">
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="labFilterSelect">
                        <option selected value="">-- Pilih Lab --</option>
                        <option value="1">Lab Komputer 1</option>
                        <option value="2">Lab Komputer 2</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn check-btn w-100">Check</button>
                </div>
            </form>
        </div>

        <div class="location mt-3">
            <p class="text-location">
                Gedung Cyber UIN SSC Lt 7, Jl. Perjuangan No.1, Karyamulya, Kec. Kesambi, Kota Cirebon, Jawa Barat 45135
            </p>
        </div>

        <!-- Content Grid -->
        <div class="row mt-4 g-3">
            <!-- Left: Lab List -->
            <div class="col-lg-8" id="labListContainer">
                <!-- Lab list akan di-render dari API -->
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Memuat daftar laboratorium...</p>
                </div>
            </div>

            <!-- Right: Latest Booking -->
            <div class="col-lg-4">
                <div class="card-custom p-3">
                    <h6 class="card-header-custom mb-3">LATEST BOOKING ROOM!</h6>
                    <div id="latestBookingContainer">
                        <!-- Latest booking akan di-render dari API -->
                        <div class="text-center py-3">
                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2 small text-muted">Memuat booking terbaru...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="mt-5">
        <p>Copyright by Kelompok 1 - Manajemen Proyek</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // ============================================
        // DASHBOARD API INTEGRATION
        // ============================================

        // API Base URL (Web route dengan session auth)
        const API_BASE_URL = '/api';

        // Get CSRF Token untuk Laravel
        function getCSRFToken() {
            return document.querySelector('meta[name="csrf-token"]')?.content || '';
        }

        // API Helper Function (menggunakan session cookie)
        async function fetchAPI(endpoint, options = {}) {
            const defaultOptions = {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'same-origin', // Include session cookie
            };

            // Jika method POST/PUT/DELETE, tambahkan CSRF token
            if (options.method && ['POST', 'PUT', 'PATCH', 'DELETE'].includes(options.method.toUpperCase())) {
                defaultOptions.headers['X-CSRF-TOKEN'] = getCSRFToken();
            }

            const config = {
                ...defaultOptions,
                ...options
            };

            try {
                const response = await fetch(`${API_BASE_URL}${endpoint}`, config);

                if (!response.ok) {
                    const errorData = await response.json().catch(() => ({
                        message: 'API request failed'
                    }));
                    throw new Error(errorData.message || 'API request failed');
                }

                const data = await response.json();
                return data;
            } catch (error) {
                console.error('API Error:', error);
                throw error;
            }
        }

        // ============================================
        // FETCH DASHBOARD STATISTICS
        // ============================================
        async function fetchDashboardStats() {
            try {
                const response = await fetchAPI('/dashboard/stats');

                if (response.success && response.data) {
                    // Update Statistic Cards
                    updateStatisticCards(response.data);
                } else {
                    console.warn('Dashboard stats response tidak valid:', response);
                }
            } catch (error) {
                console.error('Error fetching dashboard stats:', error);
                // Tampilkan error message ke user
                const errorMsg = document.createElement('div');
                errorMsg.className = 'alert alert-warning mt-3';
                errorMsg.textContent = 'Gagal memuat statistik dashboard. Silakan refresh halaman.';
                document.querySelector('.stats').prepend(errorMsg);
            }
        }

        function updateStatisticCards(data) {
            // Update Card 1: Total Peminjaman
            const totalPeminjamanEl = document.getElementById('totalPeminjaman');
            if (totalPeminjamanEl && data.total_peminjaman !== undefined) {
                totalPeminjamanEl.textContent = data.total_peminjaman;
            }

            // Update Card 2: Kelas Paling Banyak Booking
            const kelasTerbanyakEl = document.getElementById('kelasTerbanyak');
            if (kelasTerbanyakEl && data.kelas_terbanyak) {
                kelasTerbanyakEl.textContent = data.kelas_terbanyak;
            }

            // Update Card 3: Jumlah Peminjaman Bulan Ini
            const peminjamanBulanEl = document.getElementById('peminjamanBulanIni');
            if (peminjamanBulanEl && data.peminjaman_bulan_ini !== undefined) {
                peminjamanBulanEl.textContent = data.peminjaman_bulan_ini;
            }
        }

        // ============================================
        // FETCH LAB LIST
        // ============================================
        async function fetchLabList() {
            try {
                const response = await fetchAPI('/lab');

                if (response.success && response.data) {
                    // Update Lab List
                    updateLabList(response.data);
                } else {
                    console.warn('Lab list response tidak valid:', response);
                }
            } catch (error) {
                console.error('Error fetching lab list:', error);
                // Tampilkan error message
                const labListContainer = document.getElementById('labListContainer');
                if (labListContainer) {
                    labListContainer.innerHTML = `
                    <div class="text-center py-5">
                        <p class="text-danger">Gagal memuat daftar laboratorium</p>
                        <button class="btn btn-sm btn-primary mt-2" onclick="fetchLabList()">Coba Lagi</button>
                    </div>
                `;
                }
            }
        }

        function updateLabList(labs) {
            const labListContainer = document.getElementById('labListContainer');
            if (!labListContainer) return;

            // Clear existing content
            labListContainer.innerHTML = '';

            // Jika tidak ada data atau bukan array
            if (!Array.isArray(labs) || labs.length === 0) {
                labListContainer.innerHTML = `
                <div class="text-center py-5">
                    <p class="text-muted">Tidak ada data laboratorium</p>
                </div>
            `;
                return;
            }

            // Render lab list dari API data
            labs.forEach((lab, index) => {
                const labName = lab.room_name || lab.nama || 'N/A';
                const labImg = `/template-dashboard/img/lab${(index % 3) + 1}.jpg`; // Rotate images

                const labCard = document.createElement('div');
                labCard.className = 'card-custom p-4 mb-3';
                labCard.innerHTML = `
                <div class="box-lab d-flex align-items-center">
                    <img src="${labImg}" class="lab-img me-3" alt="${labName}">
                    <div class="pemisah-box">
                        <p class="mb-1 fw-semibold">${labName}</p>
                        <p class="mb-1 small">Status : ${lab.is_available ? 'Tersedia' : 'Tidak Tersedia'}<br>Lokasi : Gedung Siber<br>Lantai : 7</p>
                        <button class="btn btn-primary btn-sm" onclick="window.location='{{ route('mahasiswa.detail') }}'">View Detail</button>
                    </div>
                </div>
            `;
                labListContainer.appendChild(labCard);
            });
        }

        // ============================================
        // FETCH LATEST BOOKING
        // ============================================
        async function fetchLatestBooking() {
            try {
                const response = await fetchAPI('/bookings/latest');

                if (response.success && response.data) {
                    // Update Latest Booking
                    updateLatestBooking(response.data);
                } else {
                    console.warn('Latest booking response tidak valid:', response);
                }
            } catch (error) {
                console.error('Error fetching latest booking:', error);
                // Tampilkan error message
                const latestBookingContainer = document.getElementById('latestBookingContainer');
                if (latestBookingContainer) {
                    latestBookingContainer.innerHTML = `
                    <div class="text-center py-3">
                        <p class="small text-danger">Gagal memuat booking terbaru</p>
                        <button class="btn btn-sm btn-primary mt-2" onclick="fetchLatestBooking()">Coba Lagi</button>
                    </div>
                `;
                }
            }
        }

        function updateLatestBooking(bookings) {
            const latestBookingContainer = document.getElementById('latestBookingContainer');
            if (!latestBookingContainer) return;

            // Clear existing content
            latestBookingContainer.innerHTML = '';

            // Jika tidak ada data atau bukan array
            if (!Array.isArray(bookings) || bookings.length === 0) {
                latestBookingContainer.innerHTML = `
                <div class="text-center py-3">
                    <p class="small text-muted">Belum ada booking</p>
                </div>
            `;
                return;
            }

            // Render latest booking dari API data
            bookings.forEach(booking => {
                // Format waktu dari start_time dan end_time
                const startTime = booking.jadwal_kelas?.start_time ?
                    new Date(booking.jadwal_kelas.start_time).toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit'
                    }) : '';
                const endTime = booking.jadwal_kelas?.end_time ?
                    new Date(booking.jadwal_kelas.end_time).toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit'
                    }) : '';
                const waktu = startTime && endTime ? `${startTime} - ${endTime}` : 'N/A';

                // Format waktu relatif (created_at_human atau booking_time_human)
                const waktuRelatif = booking.booking_time_human || booking.created_at_human || 'Baru saja';
                const waktuRelatifText = waktuRelatif.includes('ago') ?
                    `Dipesan ${waktuRelatif.replace(' ago', ' yang lalu')}` :
                    `Dipesan ${waktuRelatif}`;

                const labName = booking.jadwal_kelas?.laboratorium?.room_name || 'N/A';
                const className = booking.jadwal_kelas?.class_name || 'N/A';
                const penanggungJawab = booking.jadwal_kelas?.penanggung_jawab || 'N/A';
                const userKelas = booking.user?.kelas || 'N/A';

                const bookingItem = document.createElement('div');
                bookingItem.className = 'latest-box';
                bookingItem.innerHTML = `
                <p class="fw-semibold mb-0">${labName}</p>
                <p class="latest-time">${waktu}</p>
                <p class="mb-0 small">${className}<br>oleh: ${userKelas}</p>
                <span class="badge badge-time mt-1">${waktuRelatifText}</span>
            `;
                latestBookingContainer.appendChild(bookingItem);
            });
        }

        // ============================================
        // HANDLE FILTER
        // ============================================
        function handleFilter() {
            const form = document.querySelector('.filter form');
            const dariTanggal = document.querySelector('.filter input[type="date"]:nth-of-type(1)');
            const sampaiTanggal = document.querySelector('.filter input[type="date"]:nth-of-type(2)');
            const labSelect = document.getElementById('labFilterSelect');
            const checkButton = document.querySelector('.filter button');

            if (checkButton) {
                checkButton.addEventListener('click', async function() {
                    const filterData = {
                        dari_tanggal: dariTanggal?.value || null,
                        sampai_tanggal: sampaiTanggal?.value || null,
                        lab_id: labSelect?.value || null
                    };

                    try {
                        // TODO: Integrate dengan API endpoint: POST /api/v1/dashboard/filter
                        // const response = await fetchAPI('/dashboard/filter', {
                        //     method: 'POST',
                        //     body: JSON.stringify(filterData)
                        // });

                        // TODO: Update UI dengan filtered data
                        console.log('Filter data:', filterData);
                    } catch (error) {
                        console.error('Error filtering data:', error);
                    }
                });
            }
        }

        // ============================================
        // POPULATE LAB DROPDOWN
        // ============================================
        async function populateLabDropdown() {
            try {
                const response = await fetchAPI('/lab');

                if (response.success && response.data) {
                    const labSelect = document.getElementById('labFilterSelect');
                    if (labSelect) {
                        // Clear existing options (kecuali option pertama)
                        const firstOption = labSelect.querySelector('option:first-child');
                        labSelect.innerHTML = '';
                        if (firstOption) {
                            labSelect.appendChild(firstOption);
                        }

                        // Add lab options
                        response.data.forEach(lab => {
                            const option = document.createElement('option');
                            option.value = lab.room_id || lab.id;
                            option.textContent = lab.room_name || lab.nama;
                            labSelect.appendChild(option);
                        });
                    }
                }
            } catch (error) {
                console.error('Error populating lab dropdown:', error);
            }
        }

        // ============================================
        // INITIALIZE DASHBOARD
        // ============================================
        function initDashboard() {
            // Load data saat page load
            fetchDashboardStats();
            fetchLabList();
            fetchLatestBooking();
            populateLabDropdown();

            // Setup filter handler
            handleFilter();
        }

        // Expose functions globally untuk onclick handlers
        window.fetchLabList = fetchLabList;
        window.fetchLatestBooking = fetchLatestBooking;

        // Run initialization saat DOM ready
        document.addEventListener('DOMContentLoaded', function() {
            initDashboard();
        });

        // ============================================
        // ANTI BACK/FORWARD BROWSER
        // ============================================
        // Anti Back/Forward Browser untuk Dashboard
        (function() {
            // Tambahkan entry baru di history
            history.pushState(null, null, location.href);

            // Flag untuk track apakah user sudah back ke login
            let isBackToLogin = false;

            // Handle ketika user tekan back/forward button
            window.onpopstate = function(event) {
                // Jika user tekan back, invalidate session dan redirect ke login
                if (!isBackToLogin) {
                    isBackToLogin = true;

                    // Buat form untuk logout
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('logout') }}';

                    // Tambahkan CSRF token
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = '{{ csrf_token() }}';
                    form.appendChild(csrfInput);

                    // Submit form untuk logout
                    document.body.appendChild(form);
                    form.submit();
                } else {
                    // Jika sudah back ke login, push state lagi
                    history.pushState(null, null, location.href);
                }
            };

            // Detect forward navigation (ketika user forward dari login ke dashboard)
            window.addEventListener('pageshow', function(event) {
                // Jika page di-load dari cache (back/forward), force reload untuk cek auth
                if (event.persisted) {
                    // Force reload untuk memastikan middleware auth berjalan
                    window.location.reload();
                }
            });

            // Prevent back button dengan menambahkan state setiap kali page load
            window.addEventListener('load', function() {
                history.pushState(null, null, location.href);
            });
        })();
    </script>

</body>

</html>
