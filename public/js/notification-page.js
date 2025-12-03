
// /public/js/notification-page.js
// =============================
//   Notification Page Logic
// =============================

let allNotifications = [];

async function loadNotifications() {
    const loadingState = document.getElementById("loadingState");
    const filterCategory = document.getElementById("filterCategory");
    const filterStatus = document.getElementById("filterStatus");
    
    if (loadingState) loadingState.style.display = "block";

    try {
        // Build filters from dropdowns
        const filters = {};
        if (filterCategory && filterCategory.value) {
            filters.category = filterCategory.value;
        }
        if (filterStatus && filterStatus.value) {
            filters.status = filterStatus.value;
        }

        const data = await NotificationService.getAll(filters);
        allNotifications = Array.isArray(data) ? data : [];

        NotificationRenderer.renderList(allNotifications);
    } catch (error) {
        console.error("Error loading notifications:", error);
        const container = document.getElementById("notificationList");
        if (container) {
            container.innerHTML = `
                <div class="alert alert-danger">
                    Gagal memuat notifikasi. Silakan refresh halaman.
                </div>
            `;
        }
    } finally {
        if (loadingState) loadingState.style.display = "none";
    }
}

function applyFilters() {
    const category = document.getElementById("filterCategory")?.value;
    const status = document.getElementById("filterStatus")?.value;

    let filtered = allNotifications;

    if (category) {
        filtered = filtered.filter(n => (n.category || n.type) === category);
    }
    if (status) {
        if (status === 'unread') {
            filtered = filtered.filter(n => !n.is_read);
        } else if (status === 'read') {
            filtered = filtered.filter(n => n.is_read);
        }
    }

    NotificationRenderer.renderList(filtered);
}

async function openNotif(id) {
    try {
        await NotificationService.markAsRead(id);
        loadNotifications();
    } catch (error) {
        console.error("Error marking notification as read:", error);
    }
}

// Initialize when DOM is ready
document.addEventListener("DOMContentLoaded", function() {
    const filterCategory = document.getElementById("filterCategory");
    const filterStatus = document.getElementById("filterStatus");
    const markAllBtn = document.getElementById("markAllBtn");

    if (filterCategory) {
        filterCategory.addEventListener("change", applyFilters);
    }
    if (filterStatus) {
        filterStatus.addEventListener("change", applyFilters);
    }
    if (markAllBtn) {
        markAllBtn.addEventListener("click", async () => {
            try {
                const result = await NotificationService.markAllRead();
                if (result && result.success) {
                    // Reload notifications immediately
                    await loadNotifications();
                } else {
                    alert(result?.message || "Gagal menandai semua notifikasi sebagai dibaca");
                }
            } catch (error) {
                console.error("Error marking all as read:", error);
                alert("Terjadi error saat menandai semua notifikasi sebagai dibaca: " + (error.message || error));
            }
        });
    }

    loadNotifications();
});
