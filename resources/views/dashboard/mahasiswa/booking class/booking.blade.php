<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Booking Laboratorium</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image" href="{{ asset('template-dashboard/img/LogoInformatics.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100..900&display=swap" rel="stylesheet">
    <style>
        body { 
            background-color: #f2f4f7;
            padding-top: 70px; 
            font-family: 'Poppins', sans-serif;
        }

        .navbar {
            background-color: #1a263e !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .navbar-brand img {
            height: 45px;
            margin-right: 8px;
        }
        .navbar-nav .nav-link {
            font-weight: 600;
            color: #fff;
            margin: 0 8px;
        }
        .navbar-nav .nav-link:hover {
            color: #004aad;
        }

        .card-left {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-top: 45px;
        }

        .info-box {
            background-color: #e8f3ff;
            border-left: 5px solid #007bff;
            padding: 15px;
            border-radius: 5px;
        }

        .schedule-table{
          border-radius: 9px;
        }
        .schedule-table th {
            background-color: #0c2340;
            color: white;
            font-size: 14px;
        }

        .badge-green {
            background-color: #c4f7c6;
            color: #0f7513;
            padding: 4px 10px;
            border-radius: 6px;
        }

        .badge-red {
            background-color: #ffc9c9;
            color: #b30000;
            padding: 4px 10px;
            border-radius: 6px;
        }
        .padding-tanggal{
          background: #F9F9F9;
          padding: 20px;
          border-radius: 7px;
          box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
          margin-bottom: 36px;
        }
        .head{
          border-radius: 7px;
        }
        .lonceng{
          width: 18px;
        }
        .navbar-fixed {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 9999;
        }
        .notifikasi{
            width: 24px;
            margin-left: 18px;
        }

        footer {
            background-color: #0c2340;
            color: white;
            padding: 15px;
            text-align: center;
            margin-top: 40px;
        }
        .schedule-table th {
            background-color: #0d2a4d;
            color: white;
            text-align: center;
        }

        .schedule-table td {
            text-align: center;
            vertical-align: middle;
            padding: 10px;
        }

        .badge-green {
            background: #a8efb4;
            color: #0d6d24;
            font-weight: 600;
            padding: 5px 15px;
            border-radius: 6px;
            cursor: pointer;
            display: inline-block;
        }

        .badge-red {
            background: #ffb6b6;
            color: #8a0000;
            font-weight: 600;
            padding: 5px 15px;
            border-radius: 6px;
            cursor: pointer;
            display: inline-block;
        }

        .schedule-table {
            border: 1px solid #ddd;
            border-radius: 6px;
            overflow: hidden;
        }
    </style>

</head>

<body>
    @include('dashboard.nav.nav-mahasiswa')

    <!-- CONTENT -->
    <div class="container-fluid p-4">
        <div class="row">
            
            <!-- FORM BOOKING -->
            <div class="col-md-3">
                <div class="card-left shadow-sm">
                    <h5 class="fw-bold mb-3">Form Booking Laboratorium</h5>

                    <p>Isi form di bawah untuk memesan laboratorium</p>

                    <div class="info-box mb-3">
                        <b>Informasi Penting</b>
                        <p style="font-size: 13px; margin-top: 8px;">
                            Semua pengguna menggunakan sistem SKS.  
                            Durasi dihitung 1 SKS = 50 menit.  
                            Maksimal 4 SKS = 200 menit.
                        </p>
                    </div>

                    <label class="fw-semibold">Pengguna Kelas</label>
                    <input type="text" class="form-control mb-2" id="penggunaKelas" readonly>

                    <label class="fw-semibold">Penggunaan Kelas</label>
                    <input type="text" class="form-control mb-2" id="penggunaanKelas" placeholder="Contoh: Pembelajaran MK Alpro 2">

                    <label class="fw-semibold">Tanggal Booking</label>
                    <input type="date" class="form-control mb-2" id="tanggalBooking" min="{{ date('Y-m-d') }}">

                    <label class="fw-semibold">Jam Mulai</label>
                    <input type="time" class="form-control mb-2" id="jamMulai" step="300">

                    <label class="fw-semibold">SKS (max 4)</label>
                    <input type="number" min="1" max="4" class="form-control mb-2" id="sksInput" value="1">

                    <label class="fw-semibold">Laboratorium</label>
                    <select class="form-select mb-3" id="laboratoriumSelect">
                        <option selected value="">-- Pilih Laboratorium --</option>
                        <!-- Akan di-populate dari API -->
                    </select>

                    <div class="p-2 bg-light rounded mb-3" id="perkiraanSelesaiBox">
                        <b>Perkiraan selesai:</b> <span id="perkiraanSelesai">-</span>  
                        <br><b>Durasi:</b> <span id="durasi">50 menit</span>
                    </div>

                    <button class="btn btn-primary w-100" id="btnKonfirmasiBooking">Konfirmasi Booking</button>
                </div>
            </div>

            <!-- JADWAL -->
            <div class="col-md-9">
                <h4 class="fw-bold mb-3">Jadwal Laboratorium</h4>

                <div class="row padding-tanggal">
                    <div class="col-md-4">
                        <label>Pilih Tanggal</label>
                        <input type="date" class="form-control" id="filterTanggal" min="{{ date('Y-m-d') }}">
                    </div>

                    <div class="col-md-4">
                        <label>Pilih Laboratorium</label>
                        <select class="form-select" id="filterLabSelect">
                            <option selected value="">-- Pilih Laboratorium --</option>
                            <!-- Akan di-populate dari API -->
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="d-block">Tampilkan</label>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="hanyaTersedia">
                            <label class="form-check-label" for="hanyaTersedia">
                                Hanya slot tersedia
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="perMinggu">
                            <label class="form-check-label" for="perMinggu">
                                Tampilkan per minggu
                            </label>
                        </div>
                    </div>
                </div>

                <!-- TABLE -->
                <div class="table-responsive shadow-sm head" id="scheduleTableContainer">
                    <div class="text-center py-4" id="scheduleLoading">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Memuat jadwal laboratorium...</p>
                    </div>
                    <!-- Week Range Heading (hanya tampil saat per minggu) -->
                    <div id="weekRangeHeading" class="mb-3" style="display: none;">
                        <h5 class="fw-bold text-center mb-0" id="weekRangeText"></h5>
                    </div>
                    <table class="table table-bordered schedule-table" id="scheduleTable" style="display: none;">
                        <thead id="scheduleTableHead">
                            <!-- Akan di-render dinamis -->
                        </thead>
                        <tbody id="scheduleTableBody">
                            <!-- Akan di-render dari API -->
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal Popup untuk Badge Tersedia -->
    <div class="modal fade" id="modalTersedia" tabindex="-1" aria-labelledby="modalTersediaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTersediaLabel">Slot Tersedia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info mb-3">
                        <strong>Kelas ini Kosong!</strong><br>
                        Cepat booking sekarang sebelum keduluan!
                    </div>
                    <p class="mb-2"><strong>Waktu:</strong> <span id="modalTersediaWaktu"></span></p>
                    <p class="mb-2"><strong>Lab:</strong> <span id="modalTersediaLab"></span></p>
                    <p class="mb-0">Klik tombol di bawah untuk mengisi form booking.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="btnFillFormBooking">Isi Form Booking</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Popup untuk Badge Penuh -->
    <div class="modal fade" id="modalPenuh" tabindex="-1" aria-labelledby="modalPenuhLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPenuhLabel">Slot Penuh</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning mb-3">
                        <strong>Slot ini sudah terbooking!</strong>
                    </div>
                    <div id="modalPenuhContent">
                        <div class="text-center py-3">
                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2 small text-muted">Memuat informasi booking...</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <footer>
        Copyright © Kelompok 1 - Manajemen Proyek
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // ============================================
    // BOOKING PAGE INITIALIZATION
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
            credentials: 'same-origin',
        };
        
        if (options.method && ['POST', 'PUT', 'PATCH', 'DELETE'].includes(options.method.toUpperCase())) {
            defaultOptions.headers['X-CSRF-TOKEN'] = getCSRFToken();
        }
        
        const config = { ...defaultOptions, ...options };
        
        try {
            const response = await fetch(`${API_BASE_URL}${endpoint}`, config);
            
            if (!response.ok) {
                const errorData = await response.json().catch(() => ({ message: 'API request failed' }));
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
    // POPULATE LABORATORIUM DROPDOWN (All Labs)
    // ============================================
    async function populateLabDropdown() {
        try {
            const response = await fetchAPI('/lab');
            
            if (response.success && response.data) {
                const filterLabSelect = document.getElementById('filterLabSelect');
                
                if (filterLabSelect) {
                    // Clear existing options (kecuali option pertama)
                    const firstOption = filterLabSelect.querySelector('option:first-child');
                    filterLabSelect.innerHTML = '';
                    if (firstOption) {
                        filterLabSelect.appendChild(firstOption);
                    }
                    
                    // Add lab options
                    response.data.forEach(lab => {
                        const option = document.createElement('option');
                        option.value = lab.room_id || lab.id;
                        option.textContent = lab.room_name || lab.nama;
                        filterLabSelect.appendChild(option);
                    });
                }
            }
        } catch (error) {
            console.error('Error populating lab dropdown:', error);
        }
    }
    
    // ============================================
    // FETCH AVAILABLE LABS (Based on Date, Time, SKS)
    // ============================================
    let fetchAvailableLabsTimeout = null;
    async function fetchAvailableLabs() {
        // Clear previous timeout untuk debounce
        if (fetchAvailableLabsTimeout) {
            clearTimeout(fetchAvailableLabsTimeout);
        }
        
        // Debounce: tunggu 500ms sebelum fetch (jangan trigger terlalu sering)
        fetchAvailableLabsTimeout = setTimeout(async () => {
            const tanggal = document.getElementById('tanggalBooking').value;
            const jamMulai = document.getElementById('jamMulai').value;
            const sks = parseInt(document.getElementById('sksInput').value) || 1;
            const labSelect = document.getElementById('laboratoriumSelect');
            
            if (!labSelect) return;
            
            // Jika tanggal atau jam belum diisi, tampilkan semua lab
            if (!tanggal || !jamMulai) {
                // Reset ke semua lab
                try {
                    const response = await fetchAPI('/lab');
                    if (response.success && response.data) {
                        updateLabDropdown(labSelect, response.data, false);
                    }
                } catch (error) {
                    console.error('Error fetching all labs:', error);
                }
                return;
            }
            
            // Show loading state
            labSelect.disabled = true;
            const originalHTML = labSelect.innerHTML;
            labSelect.innerHTML = '<option value="">Memuat lab tersedia...</option>';
            
            try {
                const params = new URLSearchParams({
                    tanggal: tanggal,
                    jam_mulai: jamMulai,
                    sks: sks
                });
                
                const response = await fetchAPI(`/lab/available?${params.toString()}`);
                
                if (response.success && response.data) {
                    if (response.data.length === 0) {
                        // Tidak ada lab tersedia
                        labSelect.innerHTML = '<option value="">Tidak ada lab tersedia untuk waktu ini</option>';
                        labSelect.disabled = true;
                        
                        // Show warning message
                        showLabAvailabilityMessage('Tidak ada laboratorium tersedia untuk tanggal dan waktu yang dipilih. Silakan pilih waktu lain.', 'warning');
                    } else {
                        // Update dropdown dengan lab tersedia
                        updateLabDropdown(labSelect, response.data, true);
                        labSelect.disabled = false;
                        
                        // Show success message
                        showLabAvailabilityMessage(`${response.data.length} laboratorium tersedia untuk waktu yang dipilih.`, 'success');
                    }
                } else {
                    throw new Error('Format response tidak valid');
                }
            } catch (error) {
                console.error('Error fetching available labs:', error);
                labSelect.innerHTML = originalHTML;
                labSelect.disabled = false;
                showLabAvailabilityMessage('Gagal memuat lab tersedia. Silakan coba lagi.', 'error');
            }
        }, 500); // Debounce 500ms
    }
    
    // ============================================
    // UPDATE LAB DROPDOWN
    // ============================================
    function updateLabDropdown(selectElement, labs, isAvailable = false) {
        selectElement.innerHTML = '';
        
        // Add default option
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = isAvailable ? '-- Pilih Laboratorium Tersedia --' : '-- Pilih Laboratorium --';
        defaultOption.selected = true;
        selectElement.appendChild(defaultOption);
        
        // Add lab options
        labs.forEach(lab => {
            const option = document.createElement('option');
            option.value = lab.room_id || lab.id;
            option.textContent = lab.room_name || lab.nama;
            selectElement.appendChild(option);
        });
    }
    
    // ============================================
    // SHOW LAB AVAILABILITY MESSAGE
    // ============================================
    function showLabAvailabilityMessage(message, type = 'info') {
        // Remove existing message
        const existingMsg = document.getElementById('labAvailabilityMessage');
        if (existingMsg) {
            existingMsg.remove();
        }
        
        // Create message element
        const msgDiv = document.createElement('div');
        msgDiv.id = 'labAvailabilityMessage';
        msgDiv.className = `alert alert-${type === 'error' ? 'danger' : type === 'warning' ? 'warning' : 'info'} alert-dismissible fade show mt-2 mb-2`;
        msgDiv.setAttribute('role', 'alert');
        msgDiv.innerHTML = `
            <small>${message}</small>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        // Insert after lab select
        const labSelect = document.getElementById('laboratoriumSelect');
        if (labSelect && labSelect.parentNode) {
            labSelect.parentNode.insertBefore(msgDiv, labSelect.nextSibling);
        }
        
        // Auto dismiss after 5 seconds (except for warnings)
        if (type !== 'warning') {
            setTimeout(() => {
                if (msgDiv && msgDiv.parentNode) {
                    msgDiv.remove();
                }
            }, 5000);
        }
    }
    
    // ============================================
    // AUTO-FILL PENGGUNA KELAS
    // ============================================
    function autoFillPenggunaKelas() {
        // TODO: Ambil dari user yang login (bisa dari session atau API)
        const penggunaKelasInput = document.getElementById('penggunaKelas');
        if (penggunaKelasInput) {
            // Placeholder - akan diisi dari user data
            penggunaKelasInput.value = 'Kelas Informatika 5 A'; // Temporary
        }
    }
    
    // ============================================
    // CALCULATE PERKIRAAN SELESAI & DURASI
    // ============================================
    function calculateSelesai() {
        const jamMulai = document.getElementById('jamMulai').value;
        const sks = parseInt(document.getElementById('sksInput').value) || 1;
        
        if (!jamMulai) {
            document.getElementById('perkiraanSelesai').textContent = '-';
            document.getElementById('durasi').textContent = '-';
            return;
        }
        
        // 1 SKS = 50 menit
        const durasiMenit = sks * 50;
        const durasiJam = Math.floor(durasiMenit / 60);
        const durasiMenitSisa = durasiMenit % 60;
        
        // Calculate end time
        const [jam, menit] = jamMulai.split(':').map(Number);
        const startDate = new Date();
        startDate.setHours(jam, menit, 0, 0);
        
        const endDate = new Date(startDate.getTime() + durasiMenit * 60000);
        const endTime = endDate.toLocaleTimeString('id-ID', { 
            hour: '2-digit', 
            minute: '2-digit',
            hour12: false 
        });
        
        // Update UI
        document.getElementById('perkiraanSelesai').textContent = endTime;
        
        let durasiText = '';
        if (durasiJam > 0) {
            durasiText = `${durasiJam} jam`;
            if (durasiMenitSisa > 0) {
                durasiText += ` ${durasiMenitSisa} menit`;
            }
        } else {
            durasiText = `${durasiMenit} menit`;
        }
        document.getElementById('durasi').textContent = durasiText;
        
        // Fetch available labs hanya jika semua field sudah diisi (jangan trigger saat auto-fill)
        if (!window.isAutoFilling) {
            fetchAvailableLabs();
        }
    }
    
    // ============================================
    // FETCH & RENDER SCHEDULE TABLE
    // ============================================
    async function fetchSchedule() {
        const tanggal = document.getElementById('filterTanggal').value || new Date().toISOString().split('T')[0];
        const roomId = document.getElementById('filterLabSelect').value;
        const hanyaTersedia = document.getElementById('hanyaTersedia').checked;
        const perMinggu = document.getElementById('perMinggu').checked;
        
        const scheduleLoading = document.getElementById('scheduleLoading');
        const scheduleTable = document.getElementById('scheduleTable');
        const scheduleTableBody = document.getElementById('scheduleTableBody');
        
        if (!scheduleLoading || !scheduleTable || !scheduleTableBody) return;
        
        // Show loading
        scheduleLoading.style.display = 'block';
        scheduleTable.style.display = 'none';
        
        try {
            const params = new URLSearchParams({
                tanggal: tanggal,
            });
            
            if (roomId) {
                params.append('room_id', roomId);
            }
            
            if (hanyaTersedia) {
                params.append('hanya_tersedia', '1');
            }
            
            if (perMinggu) {
                params.append('per_minggu', '1');
            }
            
            const response = await fetchAPI(`/jadwal?${params.toString()}`);
            
            if (response.success && response.data) {
                renderScheduleTable(response.data, hanyaTersedia, perMinggu, tanggal);
                scheduleLoading.style.display = 'none';
                scheduleTable.style.display = 'table';
                
                // Setup modal listeners setelah tabel di-render
                setTimeout(() => {
                    setupModalListeners();
                }, 100);
            } else {
                throw new Error('Format response tidak valid');
            }
        } catch (error) {
            console.error('Error fetching schedule:', error);
            const colspan = perMinggu ? 6 : 2;
            scheduleTableBody.innerHTML = `
                <tr>
                    <td colspan="${colspan}" class="text-center text-danger py-4">
                        Gagal memuat jadwal. Silakan coba lagi.
                    </td>
                </tr>
            `;
            scheduleLoading.style.display = 'none';
            scheduleTable.style.display = 'table';
        }
    }
    
    // ============================================
    // RENDER SCHEDULE TABLE
    // ============================================
    function renderScheduleTable(schedules, hanyaTersedia = false, perMinggu = false, tanggal = '') {
        const scheduleTableHead = document.getElementById('scheduleTableHead');
        const scheduleTableBody = document.getElementById('scheduleTableBody');
        if (!scheduleTableHead || !scheduleTableBody) return;
        
        // Generate time slots (07:00 - 17:00, 30 minutes interval)
        const timeSlots = [];
        for (let hour = 7; hour < 18; hour++) {
            for (let minute = 0; minute < 60; minute += 30) {
                const startTime = `${String(hour).padStart(2, '0')}:${String(minute).padStart(2, '0')}`;
                const endMinute = minute + 30;
                const endHour = endMinute >= 60 ? hour + 1 : hour;
                const finalMinute = endMinute >= 60 ? endMinute - 60 : endMinute;
                const endTime = `${String(endHour).padStart(2, '0')}:${String(finalMinute).padStart(2, '0')}`;
                
                if (endHour < 18) {
                    timeSlots.push({ start: startTime, end: endTime });
                }
            }
        }
        
        // Render week range heading
        const weekRangeHeading = document.getElementById('weekRangeHeading');
        const weekRangeText = document.getElementById('weekRangeText');
        
        if (perMinggu && tanggal) {
            // Calculate Monday and Friday of the week
            const selectedDate = new Date(tanggal + 'T00:00:00');
            const dayOfWeek = selectedDate.getDay(); // 0 = Sunday, 1 = Monday, etc.
            const diff = dayOfWeek === 0 ? -6 : 1 - dayOfWeek;
            
            const monday = new Date(selectedDate);
            monday.setDate(selectedDate.getDate() + diff);
            
            const friday = new Date(monday);
            friday.setDate(monday.getDate() + 4);
            
            // Format dates
            const dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu'];
            const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            
            const mondayDay = monday.getDate();
            const mondayMonth = monthNames[monday.getMonth()];
            const mondayYear = monday.getFullYear();
            
            const fridayDay = friday.getDate();
            const fridayMonth = monthNames[friday.getMonth()];
            const fridayYear = friday.getFullYear();
            
            // Format heading based on same month or different month
            let headingText = '';
            if (mondayMonth === fridayMonth && mondayYear === fridayYear) {
                // Same month: "17 - 21 November 2025"
                headingText = `${mondayDay} - ${fridayDay} ${mondayMonth} ${mondayYear}`;
            } else {
                // Different month: "29 November - 3 Desember 2025"
                headingText = `${mondayDay} ${mondayMonth} - ${fridayDay} ${fridayMonth} ${fridayYear}`;
            }
            
            if (weekRangeText) {
                weekRangeText.textContent = headingText;
            }
            if (weekRangeHeading) {
                weekRangeHeading.style.display = 'block';
            }
        } else {
            if (weekRangeHeading) {
                weekRangeHeading.style.display = 'none';
            }
        }
        
        // Render table header
        if (perMinggu) {
            // Per minggu: format "Hari, Tanggal"
            const selectedDate = new Date(tanggal + 'T00:00:00');
            const dayOfWeek = selectedDate.getDay();
            const diff = dayOfWeek === 0 ? -6 : 1 - dayOfWeek;
            
            const monday = new Date(selectedDate);
            monday.setDate(selectedDate.getDate() + diff);
            
            const tuesday = new Date(monday);
            tuesday.setDate(monday.getDate() + 1);
            
            const wednesday = new Date(monday);
            wednesday.setDate(monday.getDate() + 2);
            
            const thursday = new Date(monday);
            thursday.setDate(monday.getDate() + 3);
            
            const friday = new Date(monday);
            friday.setDate(monday.getDate() + 4);
            
            const dayNames = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at'];
            const dates = [monday, tuesday, wednesday, thursday, friday];
            
            let headerHTML = '<tr><th>Waktu</th>';
            dates.forEach((date, index) => {
                const dayName = dayNames[index];
                const day = date.getDate();
                headerHTML += `<th>${dayName}, ${day}</th>`;
            });
            headerHTML += '</tr>';
            
            scheduleTableHead.innerHTML = headerHTML;
        } else {
            // Per hari: format "Rabu, 19 Nov"
            const selectedDate = new Date(tanggal + 'T00:00:00');
            const dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu'];
            const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            const dayName = dayNames[selectedDate.getDay()];
            const day = selectedDate.getDate();
            const month = monthNames[selectedDate.getMonth()];
            const headerText = `${dayName}, ${day} ${month}`;
            
            scheduleTableHead.innerHTML = `
                <tr>
                    <th>Waktu</th>
                    <th>${headerText}</th>
                </tr>
            `;
        }
        
        // Day mapping (Monday = 1, Tuesday = 2, ..., Friday = 5)
        const dayMapping = {
            1: 'Senin',
            2: 'Selasa',
            3: 'Rabu',
            4: 'Kamis',
            5: 'Jum\'at'
        };
        
        // Build schedule map: {day_index: {time_slot: schedule}}
        const scheduleMap = {};
        schedules.forEach(schedule => {
            const dayIndex = schedule.day_index; // 1 = Monday, 2 = Tuesday, etc.
            const timeStart = schedule.time_start;
            const timeEnd = schedule.time_end;
            
            if (!scheduleMap[dayIndex]) {
                scheduleMap[dayIndex] = {};
            }
            
            // Find which time slots this schedule covers
            timeSlots.forEach(slot => {
                // Check if schedule overlaps with this time slot
                if (timeStart < slot.end && timeEnd > slot.start) {
                    scheduleMap[dayIndex][slot.start] = schedule;
                }
            });
        });
        
        // Get selected date day index for single day view
        let selectedDayIndex = null;
        let isWeekend = false;
        if (!perMinggu && tanggal) {
            const selectedDate = new Date(tanggal + 'T00:00:00');
            const dayOfWeek = selectedDate.getDay(); // 0 = Sunday, 1 = Monday, etc.
            selectedDayIndex = dayOfWeek === 0 ? 7 : dayOfWeek; // Convert to 1-7 format
            // Only show if Monday-Friday (1-5)
            if (selectedDayIndex < 1 || selectedDayIndex > 5) {
                selectedDayIndex = null;
                isWeekend = true;
            }
        }
        
        // Render table rows
        scheduleTableBody.innerHTML = '';
        
        // If weekend and single day view, show message
        if (isWeekend && !perMinggu) {
            scheduleTableBody.innerHTML = `
                <tr>
                    <td colspan="2" class="text-center text-muted py-4">
                        <p class="mb-0">Jadwal hanya tersedia untuk hari kerja (Senin-Jumat)</p>
                        <small>Aktifkan "Tampilkan per minggu" untuk melihat jadwal minggu ini</small>
                    </td>
                </tr>
            `;
            return;
        }
        
        timeSlots.forEach(slot => {
            let cells = [];
            
            // Get room_id from filter
            const filterLabSelect = document.getElementById('filterLabSelect');
            const roomId = filterLabSelect ? filterLabSelect.value : '';
            
            if (perMinggu) {
                // Per minggu: 5 hari
                cells = [
                    renderScheduleCell(1, slot.start, scheduleMap, hanyaTersedia, tanggal, roomId),
                    renderScheduleCell(2, slot.start, scheduleMap, hanyaTersedia, tanggal, roomId),
                    renderScheduleCell(3, slot.start, scheduleMap, hanyaTersedia, tanggal, roomId),
                    renderScheduleCell(4, slot.start, scheduleMap, hanyaTersedia, tanggal, roomId),
                    renderScheduleCell(5, slot.start, scheduleMap, hanyaTersedia, tanggal, roomId)
                ];
            } else {
                // Per hari: 1 hari saja
                if (selectedDayIndex) {
                    cells = [renderScheduleCell(selectedDayIndex, slot.start, scheduleMap, hanyaTersedia, tanggal, roomId)];
                } else {
                    // Weekend, show empty
                    cells = [''];
                }
            }
            
            // Jika filter "hanya tersedia" aktif dan semua cell kosong, skip row ini
            if (hanyaTersedia && cells.every(cell => cell === '')) {
                return;
            }
            
            const row = document.createElement('tr');
            let rowHTML = `<td><strong>${slot.start} - ${slot.end}</strong></td>`;
            
            if (perMinggu) {
                rowHTML += `
                    <td>${cells[0] || ''}</td>
                    <td>${cells[1] || ''}</td>
                    <td>${cells[2] || ''}</td>
                    <td>${cells[3] || ''}</td>
                    <td>${cells[4] || ''}</td>
                `;
            } else {
                rowHTML += `<td>${cells[0] || ''}</td>`;
            }
            
            row.innerHTML = rowHTML;
            scheduleTableBody.appendChild(row);
        });
    }
    
    // ============================================
    // RENDER SCHEDULE CELL
    // ============================================
    function renderScheduleCell(dayIndex, timeSlot, scheduleMap, hanyaTersedia, tanggal = '', roomId = '') {
        const schedule = scheduleMap[dayIndex] && scheduleMap[dayIndex][timeSlot];
        
        if (schedule) {
            // Ada jadwal (Penuh)
            if (hanyaTersedia) {
                // Jika filter "hanya tersedia" aktif, jangan tampilkan slot yang penuh
                return '';
            }
            // Tambahkan data attributes untuk modal
            const scheduleData = JSON.stringify({
                class_id: schedule.class_id,
                class_name: schedule.class_name,
                room_id: schedule.room_id,
                room_name: schedule.room_name,
                penanggung_jawab: schedule.penanggung_jawab,
                time_start: schedule.time_start,
                time_end: schedule.time_end,
                day_index: dayIndex
            }).replace(/"/g, '&quot;');
            
            return `<span class="badge-red badge-schedule" 
                        data-schedule='${scheduleData}'
                        data-bs-toggle="modal" 
                        data-bs-target="#modalPenuh"
                        style="cursor: pointer;"
                        title="Klik untuk melihat informasi booking">Penuh</span>`;
        } else {
            // Tidak ada jadwal (Tersedia)
            // Hitung tanggal untuk slot ini
            const selectedDate = new Date(tanggal + 'T00:00:00');
            const dayOfWeek = selectedDate.getDay();
            const diff = dayOfWeek === 0 ? -6 : 1 - dayOfWeek;
            const monday = new Date(selectedDate);
            monday.setDate(selectedDate.getDate() + diff);
            const targetDate = new Date(monday);
            targetDate.setDate(monday.getDate() + (dayIndex - 1));
            
            const slotData = JSON.stringify({
                tanggal: targetDate.toISOString().split('T')[0],
                waktu: timeSlot,
                room_id: roomId,
                day_index: dayIndex
            }).replace(/"/g, '&quot;');
            
            return `<span class="badge-green badge-slot" 
                        data-slot='${slotData}'
                        data-bs-toggle="modal" 
                        data-bs-target="#modalTersedia"
                        style="cursor: pointer;"
                        title="Klik untuk booking">Tersedia</span>`;
        }
    }
    
    // ============================================
    // ============================================
    // READ URL PARAMETERS AND AUTO-FILL FORM
    // ============================================
    function readURLParameters() {
        const urlParams = new URLSearchParams(window.location.search);
        const tanggal = urlParams.get('tanggal');
        const labId = urlParams.get('lab');
        
        if (tanggal || labId) {
            // Set flag untuk mencegah trigger fetchAvailableLabs
            window.isAutoFilling = true;
            
            // Fill tanggal booking
            if (tanggal) {
                const tanggalBooking = document.getElementById('tanggalBooking');
                if (tanggalBooking) {
                    tanggalBooking.value = tanggal;
                }
                
                // Juga set tanggal filter
                const filterTanggal = document.getElementById('filterTanggal');
                if (filterTanggal) {
                    filterTanggal.value = tanggal;
                }
            }
            
            // Fill lab jika ada
            if (labId) {
                // Fetch semua lab dulu untuk mendapatkan nama lab
                fetchAPI('/lab').then(response => {
                    if (response.success && response.data) {
                        const lab = response.data.find(l => (l.room_id || l.id) == labId);
                        if (lab) {
                            const labSelect = document.getElementById('laboratoriumSelect');
                            const filterLabSelect = document.getElementById('filterLabSelect');
                            
                            // Update lab dropdown di form booking
                            if (labSelect) {
                                labSelect.innerHTML = '';
                                const defaultOption = document.createElement('option');
                                defaultOption.value = '';
                                defaultOption.textContent = '-- Pilih Laboratorium --';
                                labSelect.appendChild(defaultOption);
                                
                                const option = document.createElement('option');
                                option.value = lab.room_id || lab.id;
                                option.textContent = lab.room_name || lab.nama;
                                option.selected = true;
                                labSelect.appendChild(option);
                            }
                            
                            // Update lab filter dropdown
                            if (filterLabSelect) {
                                filterLabSelect.value = labId;
                            }
                        }
                        
                        // Reset flag setelah selesai
                        setTimeout(() => {
                            window.isAutoFilling = false;
                            // Fetch available labs dan schedule setelah auto-fill selesai
                            if (tanggal) {
                                fetchAvailableLabs();
                                fetchSchedule();
                            }
                        }, 300);
                    }
                }).catch(error => {
                    console.error('Error fetching labs:', error);
                    window.isAutoFilling = false;
                });
            } else {
                // Jika tidak ada lab, reset flag dan fetch available labs
                setTimeout(() => {
                    window.isAutoFilling = false;
                    if (tanggal) {
                        fetchAvailableLabs();
                        fetchSchedule();
                    }
                }, 300);
            }
        }
    }
    
    // INITIALIZE BOOKING PAGE
    // ============================================
    function initBookingPage() {
        // Auto-fill pengguna kelas
        autoFillPenggunaKelas();
        
        // Populate filter lab dropdown (untuk filter jadwal)
        populateLabDropdown();
        
        // Read URL parameters dan auto-fill form
        readURLParameters();
        
        // Setup event listeners untuk form booking
        document.getElementById('sksInput').addEventListener('input', function() {
            if (!window.isAutoFilling) {
                calculateSelesai();
            }
        });
        document.getElementById('jamMulai').addEventListener('change', function() {
            if (!window.isAutoFilling) {
                calculateSelesai();
            }
        });
        document.getElementById('tanggalBooking').addEventListener('change', function() {
            if (!window.isAutoFilling) {
                fetchAvailableLabs();
            }
        });
        
        // Setup event listener untuk submit booking
        document.getElementById('btnKonfirmasiBooking').addEventListener('click', submitBooking);
        
        // Setup event listeners untuk filter jadwal
        document.getElementById('filterTanggal').addEventListener('change', fetchSchedule);
        document.getElementById('filterLabSelect').addEventListener('change', fetchSchedule);
        document.getElementById('hanyaTersedia').addEventListener('change', fetchSchedule);
        document.getElementById('perMinggu').addEventListener('change', fetchSchedule);
        
        // Set default tanggal filter ke hari ini (jika tidak ada dari URL)
        const filterTanggal = document.getElementById('filterTanggal');
        if (filterTanggal && !filterTanggal.value) {
            filterTanggal.value = new Date().toISOString().split('T')[0];
        }
        
        // Initial: populate all labs (jika belum di-fill dari URL)
        if (!window.isAutoFilling) {
            fetchAPI('/lab').then(response => {
                if (response.success && response.data) {
                    const labSelect = document.getElementById('laboratoriumSelect');
                    updateLabDropdown(labSelect, response.data, false);
                }
            }).catch(error => {
                console.error('Error initializing labs:', error);
            });
        }
        
        // Initial calculation
        calculateSelesai();
        
        // Initial fetch schedule (akan auto-setup modal listeners)
        fetchSchedule();
    }
    
    // ============================================
    // SETUP MODAL EVENT LISTENERS
    // ============================================
    function setupModalListeners() {
        // Event listener untuk badge Tersedia
        document.querySelectorAll('.badge-slot').forEach(badge => {
            badge.addEventListener('click', function() {
                const slotData = JSON.parse(this.getAttribute('data-slot'));
                const filterLabSelect = document.getElementById('filterLabSelect');
                const labName = filterLabSelect.options[filterLabSelect.selectedIndex]?.text || 'Lab yang dipilih';
                
                // Update modal content
                document.getElementById('modalTersediaWaktu').textContent = `${slotData.tanggal} ${slotData.waktu}`;
                document.getElementById('modalTersediaLab').textContent = labName;
                
                // Store slot data untuk auto-fill form
                window.selectedSlotData = slotData;
            });
        });
        
        // Event listener untuk badge Penuh
        document.querySelectorAll('.badge-schedule').forEach(badge => {
            badge.addEventListener('click', function() {
                const scheduleData = JSON.parse(this.getAttribute('data-schedule'));
                fetchBookingInfo(scheduleData.class_id);
            });
        });
        
        // Event listener untuk tombol "Isi Form Booking"
        const btnFillFormBooking = document.getElementById('btnFillFormBooking');
        if (btnFillFormBooking) {
            btnFillFormBooking.addEventListener('click', function() {
                fillFormFromSlot();
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalTersedia'));
                if (modal) modal.hide();
            });
        }
    }
    
    // ============================================
    // FETCH BOOKING INFO (untuk badge Penuh)
    // ============================================
    async function fetchBookingInfo(classId) {
        const modalPenuhContent = document.getElementById('modalPenuhContent');
        if (!modalPenuhContent) return;
        
        try {
            const response = await fetchAPI(`/booking/info?class_id=${classId}`);
            
            if (response.success && response.data) {
                const booking = response.data;
                const user = booking.user || {};
                const jadwal = booking.jadwal_kelas || {};
                
                modalPenuhContent.innerHTML = `
                    <div class="mb-3">
                        <p class="mb-2"><strong>Kelas:</strong> ${jadwal.class_name || 'N/A'}</p>
                        <p class="mb-2"><strong>Lab:</strong> ${jadwal.laboratorium?.room_name || 'N/A'}</p>
                        <p class="mb-2"><strong>Waktu:</strong> ${jadwal.time_start || 'N/A'} - ${jadwal.time_end || 'N/A'}</p>
                        <p class="mb-2"><strong>Penanggung Jawab:</strong> ${jadwal.penanggung_jawab || 'N/A'}</p>
                    </div>
                    <hr>
                    <div>
                        <h6 class="mb-2">Dibooking oleh:</h6>
                        <p class="mb-1"><strong>Nama:</strong> ${user.name || 'N/A'}</p>
                        <p class="mb-1"><strong>Kelas:</strong> ${user.kelas || 'N/A'}</p>
                        <p class="mb-0"><strong>Username:</strong> ${user.username || 'N/A'}</p>
                    </div>
                `;
            } else {
                throw new Error('Format response tidak valid');
            }
        } catch (error) {
            console.error('Error fetching booking info:', error);
            modalPenuhContent.innerHTML = `
                <div class="alert alert-danger">
                    Gagal memuat informasi booking. Silakan coba lagi.
                </div>
            `;
        }
    }
    
    // ============================================
    // FILL FORM FROM SLOT (auto-fill form booking)
    // ============================================
    function fillFormFromSlot() {
        if (!window.selectedSlotData) return;
        
        const slot = window.selectedSlotData;
        const filterLabSelect = document.getElementById('filterLabSelect');
        
        // Set flag untuk mencegah trigger fetchAvailableLabs
        window.isAutoFilling = true;
        
        // Fill form fields
        document.getElementById('tanggalBooking').value = slot.tanggal;
        
        // Parse waktu (format: "HH:MM")
        const [hour, minute] = slot.waktu.split(':');
        const timeValue = `${hour}:${minute}`;
        document.getElementById('jamMulai').value = timeValue;
        
        // Set lab di form booking (jangan trigger fetchAvailableLabs)
        const labSelect = document.getElementById('laboratoriumSelect');
        if (slot.room_id && labSelect) {
            // Get lab name dari dropdown filter
            const labName = filterLabSelect?.options[filterLabSelect.selectedIndex]?.text || 'Lab yang dipilih';
            
            // Update lab dropdown di form booking tanpa trigger
            labSelect.innerHTML = '';
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = '-- Pilih Laboratorium --';
            labSelect.appendChild(defaultOption);
            
            const option = document.createElement('option');
            option.value = slot.room_id;
            option.textContent = labName;
            option.selected = true;
            labSelect.appendChild(option);
        }
        
        // Trigger calculation (tanpa fetch available labs)
        calculateSelesai();
        
        // Reset flag setelah selesai
        setTimeout(() => {
            window.isAutoFilling = false;
            // Fetch available labs setelah auto-fill selesai (dengan delay untuk memastikan form sudah terisi)
            setTimeout(() => {
                fetchAvailableLabs();
            }, 300);
        }, 200);
        
        // Scroll to form
        document.querySelector('.card-left').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
    
    // ============================================
    // SUBMIT BOOKING
    // ============================================
    async function submitBooking() {
        const btnSubmit = document.getElementById('btnKonfirmasiBooking');
        const originalText = btnSubmit.textContent;
        
        // Get form values
        const penggunaanKelas = document.getElementById('penggunaanKelas').value.trim();
        const roomId = document.getElementById('laboratoriumSelect').value;
        const tanggal = document.getElementById('tanggalBooking').value;
        const jamMulai = document.getElementById('jamMulai').value;
        const sks = parseInt(document.getElementById('sksInput').value) || 1;
        
        // Validation
        if (!penggunaanKelas) {
            alert('Mohon isi "Penggunaan Kelas"');
            document.getElementById('penggunaanKelas').focus();
            return;
        }
        
        if (!roomId) {
            alert('Mohon pilih Laboratorium');
            document.getElementById('laboratoriumSelect').focus();
            return;
        }
        
        if (!tanggal) {
            alert('Mohon pilih Tanggal Booking');
            document.getElementById('tanggalBooking').focus();
            return;
        }
        
        if (!jamMulai) {
            alert('Mohon pilih Jam Mulai');
            document.getElementById('jamMulai').focus();
            return;
        }
        
        // Disable button & show loading
        btnSubmit.disabled = true;
        btnSubmit.textContent = 'Memproses...';
        
        try {
            const response = await fetchAPI('/booking', {
                method: 'POST',
                body: JSON.stringify({
                    penggunaan_kelas: penggunaanKelas,
                    room_id: roomId,
                    tanggal: tanggal,
                    jam_mulai: jamMulai,
                    sks: sks
                })
            });
            
            if (response.success) {
                // Success
                alert('Booking berhasil dibuat!');
                
                // Reset form
                document.getElementById('penggunaanKelas').value = '';
                document.getElementById('laboratoriumSelect').value = '';
                document.getElementById('tanggalBooking').value = '';
                document.getElementById('jamMulai').value = '';
                document.getElementById('sksInput').value = '1';
                calculateSelesai();
                
                // Refresh schedule table
                fetchSchedule();
                
                // Refresh available labs
                fetchAvailableLabs();
            } else {
                throw new Error(response.message || 'Gagal membuat booking');
            }
        } catch (error) {
            console.error('Error submitting booking:', error);
            alert(error.message || 'Gagal membuat booking. Silakan coba lagi.');
        } finally {
            // Re-enable button
            btnSubmit.disabled = false;
            btnSubmit.textContent = originalText;
        }
    }
    
    // Run initialization saat DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        initBookingPage();
    });
    </script>



</body>
</html>
