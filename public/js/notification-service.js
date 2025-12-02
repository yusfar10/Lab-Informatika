// =============================
//  Notification API Service
// =============================

const NotificationService = {

    async getAll() {
        try {
            const res = await fetch('/api/notifications');
            return await res.json();
        } catch (e) {
            console.error("Gagal mengambil notifikasi:", e);
            return [];
        }
    },

    async markAsRead(id) {
        try {
            const res = await fetch(`/api/notifications/${id}/read`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            return await res.json();
        } catch (e) {
            console.error("Gagal mengubah status:", e);
        }
    },

    async markAllRead() {
        try {
            const res = await fetch(`/api/notifications/mark-all`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            return await res.json();
        } catch (e) {
            console.error("Gagal tandai semua:", e);
        }
    }
};
