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
