// =============================
//  Notification API Service
// =============================

const NotificationService = {
    // Get CSRF Token
    getCSRFToken() {
        return document.querySelector('meta[name="csrf-token"]')?.content || '';
    },

    // Fetch API helper
    async fetchAPI(url, options = {}) {
        const defaultOptions = {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            credentials: 'same-origin',
        };

        // Add CSRF token for POST/PUT/DELETE
        if (options.method && ['POST', 'PUT', 'PATCH', 'DELETE'].includes(options.method.toUpperCase())) {
            defaultOptions.headers['X-CSRF-TOKEN'] = this.getCSRFToken();
        }

        const config = { ...defaultOptions, ...options };
        const response = await fetch(url, config);
        
        if (!response.ok) {
            throw new Error(`API error: ${response.status}`);
        }
        
        return await response.json();
    },

    async getAll(filters = {}) {
        try {
            // Add cache busting to prevent stale data
            const timestamp = new Date().getTime();
            filters.t = timestamp;
            const params = new URLSearchParams(filters).toString();
            const url = `/api/notification?${params}`;
            const data = await this.fetchAPI(url, {
                headers: {
                    'Cache-Control': 'no-cache'
                }
            });
            return data.success ? data.data : [];
        } catch (e) {
            console.error("Gagal mengambil notifikasi:", e);
            return [];
        }
    },

    async getUnreadCount() {
        try {
            const data = await this.fetchAPI('/api/notification/unread-count');
            return data.success ? data.count : 0;
        } catch (e) {
            console.error("Gagal mengambil unread count:", e);
            return 0;
        }
    },

    async markAsRead(id) {
        try {
            const data = await this.fetchAPI(`/api/notification/${id}`, {
                method: 'PUT'
            });
            return data;
        } catch (e) {
            console.error("Gagal mengubah status:", e);
            throw e;
        }
    },

    async markAllRead() {
        try {
            const data = await this.fetchAPI('/api/notification/mark-all-read', {
                method: 'PUT'
            });
            return data;
        } catch (e) {
            console.error("Gagal tandai semua:", e);
            throw e;
        }
    }
};
