// ======================================
//   Renderer: Ubah JSON → HTML Notifikasi
// ======================================

const NotificationRenderer = {

    renderList(notifications) {
        const container = document.getElementById("notificationList");
        container.innerHTML = "";

        if (!notifications.length) {
            container.innerHTML = `
                <p class="text-muted text-center mt-4">Tidak ada notifikasi.</p>
            `;
            return;
        }

        notifications.forEach(n => {
            container.innerHTML += `
                <div class="item-notif ${n.status === 'unread' ? "unread" : ""}" onclick="openNotif(${n.id})">
                    <span class="badge-category ${this.color(n.type)}">${this.formatCategory(n.type)}</span>
                    ${n.message}
                    <div class="text-muted mt-1" style="font-size:12px;">
                        ${this.formatDate(n.created_at)}
                    </div>
                </div>
            `;
        });
    },

    color(type) {
        switch(type) {
            case 'booking': return "bg-primary";
            case 'pengumuman': return "bg-success";
            case 'peringatan': return "bg-warning";
            default: return "bg-secondary";
        }
    },

    formatCategory(type) {
        return type.charAt(0).toUpperCase() + type.slice(1);
    },

    formatDate(date) {
        return new Date(date).toLocaleString("id-ID");
    }
};
