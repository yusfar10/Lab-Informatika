// public/js/notification-service.js

// Ambil CSRF token dari meta tag
function getCsrfToken() {
    const el = document.querySelector('meta[name="csrf-token"]');
    return el ? el.getAttribute('content') : '';
}

// fetch helper: session auth + CSRF
async function fetchAPI(url, options = {}) {
    const token = getCsrfToken();

    const defaultOptions = {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        credentials: 'same-origin'
    };

    const finalOptions = {
        ...defaultOptions,
        ...options,
        headers: { ...defaultOptions.headers, ...(options.headers || {}) }
    };

    const res = await fetch(url, finalOptions);

    if (!res.ok) {
        // try parse json error body for debugging
        let body = null;
        try { body = await res.json(); } catch (e) { /* ignore */ }
        const err = new Error(`HTTP ${res.status}`);
        err.status = res.status;
        err.body = body;
        throw err;
    }

    // If no content
    if (res.status === 204) return null;
    return res.json();
}

const NotificationService = {
    // GET list (paginated). filters: category, status, page, per_page
    async fetchNotifications(filters = {}) {
        const query = new URLSearchParams(filters).toString();
        const url = `/api/v1/notification` + (query ? `?${query}` : '');
        return fetchAPI(url);
    },

    // PUT mark single read
    async markAsRead(id) {
        return fetchAPI(`/api/v1/notification/${id}`, {
            method: 'PUT'
        });
    },

    // PUT mark all read
    async markAllAsRead() {
        return fetchAPI(`/api/v1/notification/mark-all-read`, {
            method: 'PUT'
        });
    },

    // GET unread-count
    async getUnreadCount() {
        return fetchAPI(`/api/v1/notification/unread-count`);
    }
};

window.NotificationService = NotificationService;
console.log('NotificationService loaded');
