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
