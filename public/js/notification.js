// public/js/notification.js

import { 
    fetchNotifications, 
    renderNotifications 
} from "/js/notification-service.js";

console.log("🔵 Notification module loaded.");

document.addEventListener("DOMContentLoaded", async () => {
    const response = await fetchNotifications({
        page: 1,
        per_page: 20
    });

    console.log("Notifikasi diterima:", response.data);

    renderNotifications(response.data);
});
async function loadRiwayatHaji() {
    try {
        const response = await NotificationService.getRiwayat();

        console.log("Data riwayat diterima:", response);

        const container = document.getElementById("riwayat-container");

        if (!container) {
            console.error("Element #riwayat-container tidak ditemukan di Blade!");
            return;
        }

        container.innerHTML = "";

        response.data.forEach(item => {
            container.innerHTML += `
                <tr>
                    <td>${item.nama}</td>
                    <td>${item.kegiatan}</td>
                    <td>${item.tanggal}</td>
                    <td>${item.status}</td>
                </tr>
            `;
        });

    } catch (err) {
        console.error("Gagal memuat riwayat:", err);
    }
}
document.addEventListener("DOMContentLoaded", function () {
    loadRiwayatHaji();
});

/* notification.js
   Safe loader: ensure the other libs are loaded and initialize
*/

(function () {
  'use strict';

  // Wait DOM ready
  function domReady(fn) {
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', fn);
    } else {
      fn();
    }
  }

  domReady(function () {
    // nothing heavy — other files define global objects
    // But we can attempt to call NotificationPage.loadBadge if present
    try {
      if (window.NotificationPage && typeof NotificationPage.loadBadge === 'function') {
        NotificationPage.loadBadge();
      }
    } catch (e) {
      console.warn('Notification init failed', e);
    }
  });

})();
