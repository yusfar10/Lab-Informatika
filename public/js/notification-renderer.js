// ======================================
//   Renderer: Ubah JSON → HTML Notifikasi
// ======================================

const NotificationRenderer = {

    renderList(notifications) {
        const container = document.getElementById("notificationList");
        if (!container) {
            console.error("Container #notificationList tidak ditemukan");
            return;
        }
        
        container.innerHTML = "";

        if (!notifications || !notifications.length) {
            container.innerHTML = `
                <p class="text-muted text-center mt-4">Tidak ada notifikasi.</p>
            `;
            return;
        }

        notifications.forEach(n => {
            const isUnread = !n.is_read;
            const message = n.pesan || n.message || 'Notifikasi';
            const time = n.notification_time || n.created_at;
            const category = n.category || n.type || 'booking';
            const isBooking = category === 'booking';
            
            // Indicator untuk unread (dot biru) atau read (checkmark hijau)
            const readIndicator = isUnread ? `
                <span style="display:inline-block; width:10px; height:10px; background:#007bff; border-radius:50%; margin-right:8px; vertical-align:middle;" title="Belum dibaca"></span>
            ` : `
                <span style="display:inline-block; width:10px; height:10px; background:#28a745; border-radius:50%; margin-right:8px; vertical-align:middle;" title="Sudah dibaca"></span>
            `;
            
            container.innerHTML += `
                <div class="item-notif ${isUnread ? "unread" : ""} ${isBooking ? "booking" : ""}" onclick="openNotif(${n.notification_id || n.id})">
                    <div style="display:flex; align-items:flex-start;">
                        ${readIndicator}
                        <div style="flex:1;">
                            <span class="badge-category ${this.color(category)}">${this.formatCategory(category)}</span>
                            ${message}
                            <div class="text-muted mt-1" style="font-size:12px;">
                                ${this.formatDate(time)}
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
    },

    color(category) {
        switch(category) {
            case 'booking': return "bg-primary";
            case 'announcement':
            case 'pengumuman': return "bg-success";
            case 'warning':
            case 'peringatan': return "bg-warning";
            case 'schedule_change': return "bg-info";
            default: return "bg-secondary";
        }
    },

    formatCategory(category) {
        const map = {
            'booking': 'Booking',
            'announcement': 'Pengumuman',
            'pengumuman': 'Pengumuman',
            'warning': 'Peringatan',
            'peringatan': 'Peringatan',
            'schedule_change': 'Perubahan Jadwal'
        };
        return map[category] || category.charAt(0).toUpperCase() + category.slice(1);
    },

    formatDate(date) {
        if (!date) return '';
        const d = new Date(date);
        return d.toLocaleString("id-ID", {
            year: "numeric",
            month: "short",
            day: "numeric",
            hour: "2-digit",
            minute: "2-digit"
        });
    }
};
