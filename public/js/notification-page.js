// =============================
//   Notification Page Logic
// =============================

let allNotifications = [];

async function loadNotifications() {
    document.getElementById("loadingState").style.display = "block";

    const data = await NotificationService.getAll();
    allNotifications = data;

    NotificationRenderer.renderList(allNotifications);

    document.getElementById("loadingState").style.display = "none";
}

function applyFilters() {
    const category = document.getElementById("filterCategory").value;
    const status = document.getElementById("filterStatus").value;

    let filtered = allNotifications;

    if (category) {
        filtered = filtered.filter(n => n.type === category);
    }
    if (status) {
        filtered = filtered.filter(n => n.status === status);
    }

    NotificationRenderer.renderList(filtered);
}

async function openNotif(id) {
    await NotificationService.markAsRead(id);
    loadNotifications();
}

document.getElementById("filterCategory").addEventListener("change", applyFilters);
document.getElementById("filterStatus").addEventListener("change", applyFilters);

document.getElementById("markAllBtn").addEventListener("click", async () => {
    await NotificationService.markAllRead();
    loadNotifications();
});

loadNotifications();
