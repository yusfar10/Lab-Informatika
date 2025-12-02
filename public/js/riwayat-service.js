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
