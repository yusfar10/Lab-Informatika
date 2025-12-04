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

    // Smooth transition dengan fade effect
    const container = document.getElementById("notificationList");
    if (container) {
        container.style.opacity = '0';
        container.style.transition = 'opacity 0.3s ease';
        
        setTimeout(() => {
            NotificationRenderer.renderList(filtered);
            // Trigger reflow untuk memastikan transition berjalan
            container.offsetHeight;
            container.style.opacity = '1';
        }, 150);
    } else {
        NotificationRenderer.renderList(filtered);
    }
}

async function openNotif(id) {
    try {
        const filterStatus = document.getElementById("filterStatus");
        const wasUnreadFilter = filterStatus && filterStatus.value === 'unread';
        
        await NotificationService.markAsRead(id);
        
        // Update local state tanpa reload full
        const index = allNotifications.findIndex(n => (n.notification_id || n.id) == id);
        if (index !== -1) {
            allNotifications[index].is_read = true;
            
            // Jika filter "Belum dibaca" aktif, reset ke "Semua Status"
            if (wasUnreadFilter && filterStatus) {
                filterStatus.value = '';
                // Re-apply filter dengan smooth transition
                applyFilters();
            } else {
                // Re-render dengan data yang sudah di-update
                if (typeof NotificationRenderer !== 'undefined' && NotificationRenderer.renderList) {
                    NotificationRenderer.renderList(allNotifications);
                }
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
            console.log('Mark all button found, attaching event listener');
            markAllBtn.addEventListener("click", async function() {
                console.log('Mark all button clicked');
                try {
                    // Disable button selama proses
                    markAllBtn.disabled = true;
                    const originalText = markAllBtn.textContent;
                    markAllBtn.textContent = 'Memproses...';
                    
                    // Gunakan fetch langsung seperti di navbar (yang berhasil)
                    const csrfToken = NotificationService.getCSRFToken();
                    console.log('CSRF Token:', csrfToken ? 'Found' : 'Missing');
                    
                    const res = await fetch("/api/notification/mark-all-read", {
                        method: "PUT",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": csrfToken
                        },
                        credentials: "same-origin"
                    });
                    
                    console.log('Response status:', res.status, res.statusText);
                    
                    // Check if response is ok
                    if (!res.ok) {
                        throw new Error(`HTTP error! status: ${res.status}`);
                    }
                    
                    const data = await res.json();
                    console.log('Response data:', data);
                    
                    if (data && data.success) {
                        // Reset filter status ke "Semua Status" setelah mark all read
                        const filterStatus = document.getElementById("filterStatus");
                        if (filterStatus) {
                            filterStatus.value = '';
                        }
                        
                        // Update all notifications in local state
                        allNotifications.forEach(n => {
                            n.is_read = true;
                        });
                        
                        // Reload notifications immediately dengan smooth transition
                        await loadNotifications();
                        
                        // Refresh badge di navbar jika ada
                        if (typeof window.refreshNotifications === 'function') {
                            window.refreshNotifications();
                        }
                        
                        console.log('Semua notifikasi berhasil ditandai sebagai dibaca');
                    } else {
                        const errorMsg = data?.message || "Gagal menandai semua notifikasi sebagai dibaca";
                        console.error('Error:', errorMsg);
                        alert(errorMsg);
                    }
                } catch (error) {
                    console.error("Error marking all as read:", error);
                    console.error("Error details:", {
                        message: error.message,
                        stack: error.stack,
                        name: error.name
                    });
                    alert("Terjadi error saat menandai semua notifikasi sebagai dibaca: " + (error.message || error));
                } finally {
                    // Re-enable button - pastikan selalu di-enable
                    if (markAllBtn) {
                        markAllBtn.disabled = false;
                        markAllBtn.textContent = 'Tandai Semua Dibaca';
                    }
                }
            });
        } else {
            console.error('Mark all button (markAllBtn) not found in DOM');
        }

        // Delete All Button Handler
        const deleteAllBtn = document.getElementById("deleteAllBtn");
        const deleteAllModal = document.getElementById("deleteAllModal");
        const confirmDeleteAllBtn = document.getElementById("confirmDeleteAllBtn");
        
        if (deleteAllBtn && deleteAllModal) {
            console.log('Delete all button and modal found');
            
            // Buka modal saat tombol diklik
            deleteAllBtn.addEventListener("click", function() {
                const modal = new bootstrap.Modal(deleteAllModal);
                modal.show();
            });

            // Handle konfirmasi delete
            if (confirmDeleteAllBtn) {
                confirmDeleteAllBtn.addEventListener("click", async function() {
                    console.log('Confirm delete all button clicked');
                    
                    // Tutup modal
                    const modalInstance = bootstrap.Modal.getInstance(deleteAllModal);
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                    
                    try {
                        // Disable button selama proses
                        deleteAllBtn.disabled = true;
                        confirmDeleteAllBtn.disabled = true;
                        const originalText = deleteAllBtn.textContent;
                        deleteAllBtn.textContent = 'Menghapus...';
                        
                        // Gunakan fetch langsung
                        const csrfToken = NotificationService.getCSRFToken();
                        console.log('CSRF Token:', csrfToken ? 'Found' : 'Missing');
                        
                        const res = await fetch("/api/notification/delete-all", {
                            method: "DELETE",
                            headers: {
                                "Content-Type": "application/json",
                                "Accept": "application/json",
                                "X-Requested-With": "XMLHttpRequest",
                                "X-CSRF-TOKEN": csrfToken
                            },
                            credentials: "same-origin"
                        });
                        
                        console.log('Response status:', res.status, res.statusText);
                        
                        // Check if response is ok
                        if (!res.ok) {
                            const errorText = await res.text();
                            console.error('Error response:', errorText);
                            throw new Error(`HTTP error! status: ${res.status}`);
                        }
                        
                        const data = await res.json();
                        console.log('Response data:', data);
                        
                        if (data && data.success) {
                            // Reset filter status
                            const filterCategory = document.getElementById("filterCategory");
                            const filterStatus = document.getElementById("filterStatus");
                            if (filterCategory) {
                                filterCategory.value = '';
                            }
                            if (filterStatus) {
                                filterStatus.value = '';
                            }
                            
                            // Clear local state
                            allNotifications = [];
                            
                            // Clear notification list
                            const container = document.getElementById("notificationList");
                            if (container) {
                                container.innerHTML = '<div class="alert alert-info">Tidak ada notifikasi</div>';
                            }
                            
                            // Refresh badge di navbar jika ada
                            if (typeof window.refreshNotifications === 'function') {
                                window.refreshNotifications();
                            }
                            
                            console.log('Semua notifikasi berhasil dihapus');
                        } else {
                            const errorMsg = data?.message || "Gagal menghapus semua notifikasi";
                            console.error('Error:', errorMsg);
                            alert(errorMsg);
                        }
                    } catch (error) {
                        console.error("Error deleting all notifications:", error);
                        console.error("Error details:", {
                            message: error.message,
                            stack: error.stack,
                            name: error.name
                        });
                        alert("Terjadi error saat menghapus semua notifikasi: " + (error.message || error));
                    } finally {
                        // Re-enable button
                        if (deleteAllBtn) {
                            deleteAllBtn.disabled = false;
                            deleteAllBtn.textContent = 'Hapus Semua Pesan';
                        }
                        if (confirmDeleteAllBtn) {
                            confirmDeleteAllBtn.disabled = false;
                        }
                    }
                });
            }
        } else {
            console.error('Delete all button or modal not found in DOM');
        }

        // Load notifications saat page load
        loadNotifications();
    }, 100); // Delay kecil untuk memastikan semua script loaded
});

