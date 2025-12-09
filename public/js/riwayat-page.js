// /public/js/riwayat-page.js
// =============================
//  Riwayat Booking Page Logic
// =============================

(function() {
    'use strict';

    // State management
    let currentFilters = {
        search: '',
        tanggal: '',
        status: 'all',
        sort: 'newest' // newest atau older
    };

    let allBookings = []; // Store all bookings untuk client-side filtering

    // Debounce helper function
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // ============================================
    // CARD 4.16: Render Functions
    // ============================================

    /**
     * Format tanggal dan waktu (contoh: "2025/11/05 20:44:10")
     */
    function formatDateTime(dateString) {
        if (!dateString) return '-';
        
        try {
            const date = new Date(dateString);
            if (isNaN(date.getTime())) return dateString;
            
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            const seconds = String(date.getSeconds()).padStart(2, '0');
            
            return `${year}/${month}/${day} ${hours}:${minutes}:${seconds}`;
        } catch (e) {
            console.error('Error formatting date:', e);
            return dateString;
        }
    }

    /**
     * Return warna badge sesuai status (bg-primary untuk aktif, bg-secondary untuk completed)
     */
    function getStatusBadgeColor(status) {
        if (!status) return 'bg-secondary';
        
        const statusLower = status.toLowerCase();
        if (statusLower === 'aktif' || statusLower === 'active' || statusLower === 'schedule') {
            return 'bg-primary'; // Biru untuk aktif
        } else if (statusLower === 'completed' || statusLower === 'pass' || statusLower === 'selesai') {
            return 'bg-secondary'; // Abu-abu untuk completed
        } else if (statusLower === 'nonaktif' || statusLower === 'inactive' || statusLower === 'cancelled') {
            return 'bg-danger'; // Merah untuk cancelled (jika masih ditampilkan)
        }
        return 'bg-secondary';
    }

    /**
     * Render single table row dengan struktur: Date & Time (Jadwal), Nama Pengguna, Ruangan, Booking Time, Status, Penggunaan Kelas, Waktu Booking Dibuat
     */
    function renderRiwayatRow(bookingData) {
        if (!bookingData) return '';

        // Extract data dengan fallback
        // Date & Time: Menampilkan tanggal/waktu jadwal kelas (start_time), bukan waktu booking dibuat
        const dateTime = formatDateTime(bookingData.jadwalKelas?.start_time || bookingData.jadwal_kelas?.start_time || bookingData.start_time || '-');
        
        // Waktu Booking Dibuat: Menampilkan created_at (kapan booking dibuat)
        const waktuBookingDibuat = formatDateTime(bookingData.created_at || bookingData.booking_time || '-');
        
        const namaPengguna = bookingData.user?.name || bookingData.penanggung_jawab || '-';
        const kelas = bookingData.user?.kelas ? ` - ${bookingData.user.kelas}` : '';
        const namaPenggunaFull = namaPengguna + kelas;
        
        // Penggunaan Kelas (dengan truncate max 30 karakter)
        let penggunaanKelas = bookingData.jadwalKelas?.class_name || 
                             bookingData.jadwal_kelas?.class_name || 
                             bookingData.class_name || '-';
        
        // Truncate jika lebih dari 30 karakter
        const maxLength = 30;
        const penggunaanKelasTruncated = penggunaanKelas.length > maxLength 
            ? penggunaanKelas.substring(0, maxLength) + '...' 
            : penggunaanKelas;
        
        const ruangan = bookingData.jadwalKelas?.laboratorium?.room_name || 
                       bookingData.jadwal_kelas?.room_name || 
                       bookingData.room_name || '-';
        
        // Booking Time (durasi/SKS)
        let bookingTime = '-';
        if (bookingData.jadwalKelas) {
            const startTime = bookingData.jadwalKelas.start_time;
            const endTime = bookingData.jadwalKelas.end_time;
            if (startTime && endTime) {
                const start = new Date(startTime);
                const end = new Date(endTime);
                const durasiMenit = Math.round((end - start) / (1000 * 60));
                const sks = Math.round(durasiMenit / 50);
                bookingTime = `${sks} SKS`;
            }
        } else if (bookingData.jadwal_kelas?.duration) {
            bookingTime = bookingData.jadwal_kelas.duration;
        } else if (bookingData.sks) {
            bookingTime = `${bookingData.sks} SKS`;
        }

        // Status - cek display_status dulu, baru fallback ke logic
        const displayStatus = bookingData.display_status || 
                     (() => {
                         const status = bookingData.jadwalKelas?.status || 
                                      bookingData.jadwal_kelas?.status || 
                                      bookingData.status || '';
                         const endTime = bookingData.jadwalKelas?.end_time || 
                                      bookingData.jadwal_kelas?.end_time;
                         
                         // Jika cancelled, skip
                         if (status === 'cancelled') {
                             return null;
                         }
                         
                         // Jika status completed
                         if (status === 'completed') {
                             return 'completed';
                         }
                         
                         // Cek waktu: jika end_time sudah lewat, otomatis completed
                         if (endTime && new Date(endTime) < new Date()) {
                             return 'completed';
                         }
                         
                         // Default: aktif
                         return 'aktif';
                     })();

        // Skip cancelled bookings dari display
        if (!displayStatus || displayStatus === 'cancelled') {
            return '';
        }

        const statusText = displayStatus === 'aktif' ? 'Aktif' : 
                          displayStatus === 'completed' ? 'Completed' : 
                          'Unknown';

        const badgeColor = getStatusBadgeColor(displayStatus);

        return `
            <tr>
                <td>${dateTime}</td>
                <td>${namaPenggunaFull}</td>
                <td>${ruangan}</td>
                <td>${bookingTime}</td>
                <td>
                    <span class="badge-status ${badgeColor}">${statusText}</span>
                </td>
                <td class="text-truncate-custom" title="${penggunaanKelas}">${penggunaanKelasTruncated}</td>
                <td>${waktuBookingDibuat}</td>
            </tr>
        `;
    }

    /**
     * Render semua rows
     */
    function renderRiwayatTable(bookingsArray) {
        const tableBody = document.getElementById('table-booking');
        if (!tableBody) {
            console.error('Table body element not found');
            return;
        }

        tableBody.innerHTML = '';

        if (!bookingsArray || bookingsArray.length === 0) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        <i class="bi bi-inbox" style="font-size: 2rem; display: block; margin-bottom: 10px;"></i>
                        Tidak ada data ditemukan
                    </td>
                </tr>
            `;
            return;
        }

        bookingsArray.forEach(booking => {
            tableBody.innerHTML += renderRiwayatRow(booking);
        });
    }

    // ============================================
    // CARD 4.17: Search & Filter Functions
    // ============================================

    /**
     * Apply filters (search + status) ke allBookings
     */
    function applyFilters() {
        let filtered = [...allBookings];

        // Filter by search term
        if (currentFilters.search.trim()) {
            const searchTerm = currentFilters.search.toLowerCase().trim();
            filtered = filtered.filter(booking => {
                const namaPengguna = (booking.user?.name || booking.penanggung_jawab || '').toLowerCase();
                const kelas = (booking.user?.kelas || '').toLowerCase();
                const ruangan = (booking.jadwalKelas?.laboratorium?.room_name || 
                               booking.jadwal_kelas?.room_name || 
                               booking.room_name || '').toLowerCase();
                const className = (booking.jadwalKelas?.class_name || 
                                 booking.jadwal_kelas?.class_name || '').toLowerCase();
                
                return namaPengguna.includes(searchTerm) ||
                       kelas.includes(searchTerm) ||
                       ruangan.includes(searchTerm) ||
                       className.includes(searchTerm);
            });
        }

        // Filter by tanggal (berdasarkan tanggal jadwal kelas, bukan waktu booking dibuat)
        if (currentFilters.tanggal && currentFilters.tanggal.trim()) {
            filtered = filtered.filter(booking => {
                // Ambil tanggal dari start_time jadwal kelas (kapan booking dibuat untuk hari apa)
                const dateField = booking.jadwalKelas?.start_time || 
                                 booking.jadwal_kelas?.start_time || 
                                 booking.start_time;
                if (!dateField) return false;
                
                try {
                    // Format tanggal menjadi YYYY-MM-DD untuk perbandingan
                    const bookingDate = new Date(dateField);
                    if (isNaN(bookingDate.getTime())) return false;
                    
                    // Format booking date ke YYYY-MM-DD
                    const bookingYear = bookingDate.getFullYear();
                    const bookingMonth = String(bookingDate.getMonth() + 1).padStart(2, '0');
                    const bookingDay = String(bookingDate.getDate()).padStart(2, '0');
                    const bookingDateStr = `${bookingYear}-${bookingMonth}-${bookingDay}`;
                    
                    // Format filter date (sudah dalam format YYYY-MM-DD dari input date)
                    const filterDateStr = currentFilters.tanggal.trim();
                    
                    // Compare string
                    return bookingDateStr === filterDateStr;
                } catch (e) {
                    console.error('Error comparing dates:', e, dateField);
                    return false;
                }
            });
        }

        // Filter by status
        if (currentFilters.status !== 'all') {
            filtered = filtered.filter(booking => {
                // Tentukan display_status untuk booking ini
                const displayStatus = booking.display_status || 
                    (() => {
                        const status = booking.jadwalKelas?.status || 
                                     booking.jadwal_kelas?.status || 
                                     booking.status || '';
                        const endTime = booking.jadwalKelas?.end_time || 
                                     booking.jadwal_kelas?.end_time;
                        
                        // Skip cancelled
                        if (status === 'cancelled') {
                            return null;
                        }
                        
                        // Completed
                        if (status === 'completed') {
                            return 'completed';
                        }
                        
                        // Cek waktu: jika sudah lewat, otomatis completed
                        if (endTime && new Date(endTime) < new Date()) {
                            return 'completed';
                        }
                        
                        // Default: aktif
                        return 'aktif';
                    })();
                
                // Filter berdasarkan display_status
                if (currentFilters.status === 'aktif') {
                    return displayStatus === 'aktif';
                } else if (currentFilters.status === 'completed') {
                    return displayStatus === 'completed';
                }
                
                return true;
            });
        }

        // Apply sorting berdasarkan waktu booking dibuat (created_at)
        filtered.sort((a, b) => {
            const dateA = new Date(a.created_at || a.booking_time || 0);
            const dateB = new Date(b.created_at || b.booking_time || 0);
            
            if (currentFilters.sort === 'newest') {
                // Newest: terbaru dulu (descending)
                return dateB - dateA;
            } else {
                // Older: terlama dulu (ascending)
                return dateA - dateB;
            }
        });

        return filtered;
    }

    // ============================================
    // CARD 4.16: Load Data Function
    // ============================================

    /**
     * Fetch data dari API dan render table
     */
    async function loadRiwayatBookings() {
        const tableBody = document.getElementById('table-booking');
        const loadingContainer = document.getElementById('loading-riwayat');
        
        if (!tableBody) {
            console.error('Table body element not found');
            return;
        }

        // Show loading state
        if (loadingContainer) {
            loadingContainer.style.display = 'block';
        }
        tableBody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Memuat data...</span>
                    </div>
                    <p class="mt-2 text-muted">Memuat riwayat booking...</p>
                </td>
            </tr>
        `;

        try {
            // Fetch data dari API
            // Map status filter: aktif -> schedule (belum lewat), completed -> completed atau sudah lewat
            let statusParam = '';
            if (currentFilters.status === 'aktif') {
                statusParam = 'aktif'; // Backend akan filter yang belum lewat
            } else if (currentFilters.status === 'completed') {
                statusParam = 'completed'; // Backend akan filter yang completed atau sudah lewat
            }

            const result = await RiwayatService.fetchRiwayatBookings({
                status: statusParam
            });

            if (!result.success) {
                throw new Error(result.message || 'Gagal mengambil data');
            }

            // Store all bookings
            allBookings = result.data || [];

            // Update filter tanggal dari input jika ada
            const filterTanggalInput = document.getElementById('filter-tanggal-riwayat');
            if (filterTanggalInput && filterTanggalInput.value) {
                currentFilters.tanggal = filterTanggalInput.value;
            }

            // Apply client-side filters (search + tanggal)
            const filteredBookings = applyFilters();

            // Render table
            renderRiwayatTable(filteredBookings);

        } catch (error) {
            console.error('Error loading riwayat bookings:', error);
            
            // Handle session expired - redirect to login
            if (error.message === 'SESSION_EXPIRED' || error.message.includes('401')) {
                alert('Session Anda telah berakhir. Silakan login kembali.');
                window.location.href = '/login';
                return;
            }
            
            // Show error state
            tableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center text-danger py-4">
                        <i class="bi bi-exclamation-triangle" style="font-size: 2rem; display: block; margin-bottom: 10px;"></i>
                        <strong>Terjadi Kesalahan</strong>
                        <p class="mt-2 mb-0" style="font-size: 0.9rem;">${error.message || 'Gagal memuat data. Silakan refresh halaman.'}</p>
                    </td>
                </tr>
            `;
        } finally {
            // Hide loading state
            if (loadingContainer) {
                loadingContainer.style.display = 'none';
            }
        }
    }

    // ============================================
    // Event Listeners & Initialization
    // ============================================

    function initEventListeners() {
        // Search input dengan debounce 300ms
        const searchInput = document.getElementById('search-riwayat');
        if (searchInput) {
            const debouncedSearch = debounce(() => {
                currentFilters.search = searchInput.value;
                const filtered = applyFilters();
                renderRiwayatTable(filtered);
                
                // Show empty state jika tidak ada hasil
                if (filtered.length === 0 && allBookings.length > 0) {
                    const tableBody = document.getElementById('table-booking');
                    if (tableBody) {
                        let emptyMessage = 'Tidak ada data yang cocok';
                        const filters = [];
                        if (currentFilters.search.trim()) {
                            filters.push(`pencarian "${currentFilters.search}"`);
                        }
                        if (currentFilters.tanggal) {
                            const selectedDate = new Date(currentFilters.tanggal).toLocaleDateString('id-ID', {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            });
                            filters.push(`tanggal ${selectedDate}`);
                        }
                        if (filters.length > 0) {
                            emptyMessage = `Tidak ada data yang cocok dengan ${filters.join(' dan ')}`;
                        }
                        
                        tableBody.innerHTML = `
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="bi bi-search" style="font-size: 2rem; display: block; margin-bottom: 10px;"></i>
                                    ${emptyMessage}
                                </td>
                            </tr>
                        `;
                    }
                }
            }, 300);

            searchInput.addEventListener('input', debouncedSearch);
            searchInput.addEventListener('keyup', debouncedSearch);
        }

        // Filter tanggal
        const filterTanggal = document.getElementById('filter-tanggal-riwayat');
        if (filterTanggal) {
            // Set initial value dari state
            if (currentFilters.tanggal) {
                filterTanggal.value = currentFilters.tanggal;
            }
            
            filterTanggal.addEventListener('change', () => {
                currentFilters.tanggal = filterTanggal.value || '';
                
                // Apply filter jika data sudah ada
                if (allBookings.length > 0) {
                    const filtered = applyFilters();
                    renderRiwayatTable(filtered);
                    
                    // Show empty state jika tidak ada hasil
                    if (filtered.length === 0) {
                        const tableBody = document.getElementById('table-booking');
                        if (tableBody) {
                            const selectedDate = filterTanggal.value ? new Date(filterTanggal.value + 'T00:00:00').toLocaleDateString('id-ID', {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            }) : '';
                            tableBody.innerHTML = `
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="bi bi-calendar-x" style="font-size: 2rem; display: block; margin-bottom: 10px;"></i>
                                        Tidak ada data untuk tanggal ${selectedDate}
                                    </td>
                                </tr>
                            `;
                        }
                    }
                } else {
                    // Jika data belum ada, reload data dengan filter
                    loadRiwayatBookings();
                }
            });
        }

        // Filter dropdown status
        const filterDropdown = document.getElementById('filter-status-riwayat');
        if (filterDropdown) {
            filterDropdown.addEventListener('change', () => {
                currentFilters.status = filterDropdown.value;
                loadRiwayatBookings();
            });
        }

        // Filter dropdown sort (Newest/Older)
        const filterSort = document.getElementById('filter-sort-riwayat');
        if (filterSort) {
            filterSort.addEventListener('change', () => {
                currentFilters.sort = filterSort.value;
                // Apply filter dan render tanpa reload dari API
                if (allBookings.length > 0) {
                    const filtered = applyFilters();
                    renderRiwayatTable(filtered);
                } else {
                    loadRiwayatBookings();
                }
            });
        }

        // Check button
        const checkButton = document.getElementById('btn-check-riwayat');
        if (checkButton) {
            checkButton.addEventListener('click', () => {
                // Reset semua filter dan reload
                currentFilters.search = '';
                currentFilters.tanggal = '';
                currentFilters.status = 'all';
                currentFilters.sort = 'newest';
                
                const searchInput = document.getElementById('search-riwayat');
                if (searchInput) searchInput.value = '';
                
                const filterTanggalInput = document.getElementById('filter-tanggal-riwayat');
                if (filterTanggalInput) filterTanggalInput.value = '';
                
                const filterStatus = document.getElementById('filter-status-riwayat');
                if (filterStatus) filterStatus.value = 'all';
                
                const filterSort = document.getElementById('filter-sort-riwayat');
                if (filterSort) filterSort.value = 'newest';
                
                loadRiwayatBookings();
            });
        }
    }

    // Initialize saat DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        initEventListeners();
        loadRiwayatBookings();
    });

})();

