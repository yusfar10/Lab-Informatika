// riwayat-service.js

// Helper fetchAPI (mengikuti helper yang sudah ada pada project lain)
async function fetchAPI(url, options = {}) {
    const defaultOptions = {
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute("content"),
        },
        credentials: "same-origin",
    };

    const finalOptions = { ...defaultOptions, ...options };

    const response = await fetch(url, finalOptions);

    // Jika unauthorized, mungkin session expired
    if (response.status === 401) {
        console.error("Unauthorized! Session expired?");
    }

    return response.json();
}

// ------------------------------
// FETCH RIWAYAT BOOKINGS
// ------------------------------
export async function fetchRiwayatBookings(filters = {}) {
    const params = new URLSearchParams(filters).toString();
    const url = `/api/bookings/riwayat?${params}`;

    return await fetchAPI(url, {
        method: "GET",
    });
}

/* riwayat-service.js
   Simple service wrapper to fetch booking history with error handling.
*/

(function (global) {
  'use strict';

  // reuse safeFetch if NService available
  const safeFetch = (window.NService && window.NService.safeFetch) ?
      window.NService.safeFetch :
      async function (url, options) {
        // minimal fallback safeFetch
        try {
          const res = await fetch(url, options);
          const c = res.headers.get('content-type') || '';
          if (c.includes('application/json')) {
            return { ok: true, data: await res.json(), status: res.status };
          } else {
            const text = await res.text();
            return { ok: res.ok, text, status: res.status, message: 'Unexpected response' };
          }
        } catch (e) {
          return { ok: false, status: 0, message: 'Koneksi bermasalah' };
        }
      };

  async function fetchRiwayatBookings(filters = {}) {
    const q = new URLSearchParams(filters).toString();
    const url = `/api/v1/bookings/history${q ? '?' + q : ''}`;
    return await safeFetch(url, { method: 'GET' });
  }

  global.RiwayatService = { fetchRiwayatBookings };

})(window);
