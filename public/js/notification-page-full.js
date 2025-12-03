// =============================
//   Notification Page Logic (Full Page)
//   File terpisah untuk halaman notifikasi lengkap
// =============================

let allNotifications = [];

async function loadNotifications() {
    const loadingState = document.getElementById("loadingState");
    const filterCategory = document.getElementById("filterCategory");
    const filterStatus = document.getElementById("filterStatus");
    const container = document.getElementById("notificationList");
    
    // Show loading hanya jika container kosong
    if (loadingState && (!container || container.innerHTML.trim() === "")) {
        loadingState.style.display = "block";
    }

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
        
        // Pastikan data adalah array
        if (Array.isArray(data)) {
            allNotifications = data;
        } else if (data && Array.isArray(data.data)) {
            allNotifications = data.data;
        } else {
            allNotifications = [];
        }

        // Render notifications
        if (typeof NotificationRenderer !== 'undefined' && NotificationRenderer.renderList) {
            NotificationRenderer.renderList(allNotifications);
        } else {
            console.error('NotificationRenderer tidak ditemukan');
        }
    } catch (error) {
        console.error("Error loading notifications:", error);
        if (container) {
            container.innerHTML = `
                <div class="alert alert-danger">
                    Gagal memuat notifikasi. Silakan refresh halaman.
                </div>
            `;
        }
    } finally {
        // Pastikan loading state di-hide
        if (loadingState) {
            loadingState.style.display = "none";
        }
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
        // Update local state tanpa reload full
        const index = allNotifications.findIndex(n => (n.notification_id || n.id) == id);
        if (index !== -1) {
            allNotifications[index].is_read = true;
            // Re-render dengan data yang sudah di-update
            if (typeof NotificationRenderer !== 'undefined' && NotificationRenderer.renderList) {
                NotificationRenderer.renderList(allNotifications);
            }
        } else {
            // Jika tidak ditemukan, reload full
            await loadNotifications();
        }
        // Refresh badge di navbar jika ada
        if (typeof window.refreshNotifications === 'function') {
            window.refreshNotifications();
        }
    } catch (error) {
        console.error("Error marking notification as read:", error);
    }
}

// Initialize when DOM is ready
document.addEventListener("DOMContentLoaded", function() {
    // Tunggu sebentar untuk memastikan semua script sudah loaded
    setTimeout(() => {
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
                        // Refresh badge di navbar jika ada
                        if (typeof window.refreshNotifications === 'function') {
                            window.refreshNotifications();
                        }
                    } else {
                        alert(result?.message || "Gagal menandai semua notifikasi sebagai dibaca");
                    }
                } catch (error) {
                    console.error("Error marking all as read:", error);
                    alert("Terjadi error saat menandai semua notifikasi sebagai dibaca: " + (error.message || error));
                }
            });
        }

        // Load notifications saat page load
        loadNotifications();
    }, 100); // Delay kecil untuk memastikan semua script loaded
});

