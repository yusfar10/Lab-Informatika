// /public/js/riwayat-service.js
// =============================
//  Riwayat Booking API Service
// =============================

const RiwayatService = {
    // Get CSRF Token
    getCSRFToken() {
        return document.querySelector('meta[name="csrf-token"]')?.content || '';
    },

    // Fetch API helper dengan error handling
    async fetchAPI(url, options = {}) {
        const defaultOptions = {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            credentials: 'same-origin',
            cache: 'no-store'
        };

        // Add CSRF token for POST/PUT/DELETE
        if (options.method && ['POST', 'PUT', 'PATCH', 'DELETE'].includes(options.method.toUpperCase())) {
            defaultOptions.headers['X-CSRF-TOKEN'] = this.getCSRFToken();
        }

        const config = { ...defaultOptions, ...options };

        try {
            const response = await fetch(url, config);

            // Handle network errors
            if (!response.ok) {
                const errorData = await response.json().catch(() => ({
                    message: `HTTP error! status: ${response.status}`
                }));

                // Handle different error status codes
                if (response.status === 401) {
                    throw new Error('SESSION_EXPIRED');
                } else if (response.status === 403) {
                    throw new Error('Akses ditolak. Anda tidak memiliki izin untuk mengakses data ini.');
                } else if (response.status === 404) {
                    throw new Error('Endpoint tidak ditemukan.');
                } else if (response.status === 500) {
                    throw new Error('Terjadi kesalahan pada server. Silakan coba lagi nanti.');
                } else {
                    throw new Error(errorData.message || `Terjadi kesalahan (Status: ${response.status})`);
                }
            }

            return await response.json();
        } catch (error) {
            // Handle network connection errors
            if (error.name === 'TypeError' && error.message.includes('fetch')) {
                throw new Error('Koneksi bermasalah. Periksa koneksi internet Anda.');
            }
            throw error;
        }
    },

    // Fetch riwayat bookings dengan filters
    async fetchRiwayatBookings(filters = {}) {
        try {
            // Add cache busting
            const timestamp = new Date().getTime();
            filters.t = timestamp;

            const params = new URLSearchParams(filters).toString();
            const url = `/api/bookings/history?${params}`;

            const data = await this.fetchAPI(url, {
                headers: {
                    'Cache-Control': 'no-cache'
                }
            });

            return {
                success: data.success !== false,
                data: data.success ? (data.data || []) : [],
                message: data.message || 'Data berhasil diambil'
            };
        } catch (error) {
            console.error('Gagal mengambil riwayat booking:', error);
            return {
                success: false,
                data: [],
                message: error.message || 'Gagal mengambil data riwayat booking'
            };
        }
    }
};

// Export untuk global window
if (typeof window !== 'undefined') {
    window.RiwayatService = RiwayatService;
}
