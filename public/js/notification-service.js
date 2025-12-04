// /public/js/notification-service.js
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
/* notification-service.js
   Helper fetch wrapper + notification API functions
   - safeFetch checks HTTP status and content-type
   - returns { ok: boolean, status, data, message }
*/

(function (global) {
  'use strict';

  // Read CSRF token from meta if present
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || null;

  // small util to read auth token from localStorage (if you use JWT)
  function getAuthToken() {
    try { return localStorage.getItem('token'); } catch (e) { return null; }
  }

  // Simple user-facing toast (non-blocking). Minimal, replace with your UI if you have one.
  function showToast(message, type = 'info', timeout = 4000) {
    if (!message) return;
    try {
      let container = document.getElementById('app-toast-container');
      if (!container) {
        container = document.createElement('div');
        container.id = 'app-toast-container';
        container.style.position = 'fixed';
        container.style.right = '16px';
        container.style.top = '16px';
        container.style.zIndex = 99999;
        document.body.appendChild(container);
      }
      const el = document.createElement('div');
      el.className = `app-toast app-toast-${type}`;
      el.style.marginTop = '8px';
      el.style.padding = '10px 14px';
      el.style.background = type === 'error' ? '#dc3545' : (type === 'success' ? '#198754' : '#0d6efd');
      el.style.color = '#fff';
      el.style.borderRadius = '6px';
      el.style.boxShadow = '0 6px 18px rgba(0,0,0,0.08)';
      el.style.fontSize = '13px';
      el.textContent = message;
      container.appendChild(el);
      setTimeout(() => {
        el.style.transition = 'opacity 300ms';
        el.style.opacity = 0;
        setTimeout(() => el.remove(), 300);
      }, timeout);
    } catch (e) {
      // no-op
      console.warn('Toast failed', e);
    }
  }

  // Generic safe fetch
  async function safeFetch(url, options = {}) {
    const defaultHeaders = {
      'Accept': 'application/json',
      'Content-Type': 'application/json',
    };

    const finalOptions = Object.assign({
      method: 'GET',
      credentials: 'same-origin'
    }, options);

    finalOptions.headers = Object.assign(defaultHeaders, finalOptions.headers || {});

    // attach CSRF token if available
    if (csrfToken && !finalOptions.headers['X-CSRF-TOKEN']) {
      finalOptions.headers['X-CSRF-TOKEN'] = csrfToken;
    }

    // attach Bearer token if available and not already provided
    const token = getAuthToken();
    if (token && !finalOptions.headers['Authorization']) {
      finalOptions.headers['Authorization'] = 'Bearer ' + token;
    }

    try {
      const res = await fetch(url, finalOptions);

      const contentType = res.headers.get('content-type') || '';

      // handle common HTTP statuses with friendly messages
      if (res.status === 401) {
        return { ok: false, status: 401, message: 'Anda perlu login ulang.' };
      }
      if (res.status === 403) {
        return { ok: false, status: 403, message: 'Akses ditolak.' };
      }
      if (res.status === 404) {
        // If you have a custom 404 page, we can optionally redirect
        return { ok: false, status: 404, message: 'Data tidak ditemukan.' };
      }
      if (res.status >= 500) {
        return { ok: false, status: res.status, message: 'Server sedang bermasalah. Coba lagi nanti.' };
      }

      // try parse JSON if content-type indicates json
      if (contentType.includes('application/json')) {
        const data = await res.json();
        return { ok: true, status: res.status, data };
      } else {
        // not JSON (maybe HTML error page), return raw text and mark as not-ok
        const text = await res.text();
        return { ok: res.ok, status: res.status, text, message: 'Unexpected response format' };
      }
    } catch (err) {
      // network or other failure
      const isNetwork = err.message && err.message.toLowerCase().includes('failed to fetch');
      return { ok: false, status: 0, message: isNetwork ? 'Koneksi internet bermasalah.' : 'Terjadi kesalahan.' };
    }
  }

  // Notification API functions (wrapped)
  async function getNotifications(params = {}) {
    const q = new URLSearchParams(params).toString();
    return await safeFetch(`/api/v1/notification${q ? '?' + q : ''}`, { method: 'GET' });
  }

  async function markNotificationAsRead(id) {
    if (!id) return { ok: false, message: 'ID not provided' };
    return await safeFetch(`/api/v1/notification/${id}`, { method: 'PUT' });
  }

  async function markAllNotificationsRead() {
    return await safeFetch(`/api/v1/notification/mark-all-read`, { method: 'PUT' });
  }

  async function unreadCount() {
    return await safeFetch(`/api/v1/notification/unread-count`, { method: 'GET' });
  }

  // expose globally
  global.NService = {
    safeFetch,
    getNotifications,
    markNotificationAsRead,
    markAllNotificationsRead,
    unreadCount,
    showToast
  };

})(window);
