// /public/js/notification-renderer.js
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
            
            // Indicator untuk unread (hijau) atau read (abu-abu)
            const readIndicator = isUnread ? `
                <span class="read-indicator unread" title="Belum dibaca"></span>
            ` : `
                <span class="read-indicator read" title="Sudah dibaca"></span>
            `;
            
            container.innerHTML += `
                <div class="item-notif ${isUnread ? "unread" : ""}" onclick="openNotif(${n.notification_id || n.id})">
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
/* notification-renderer.js
   Renders notification list & unread badge.
   Assumes markup placeholders:
   - #notif-badge (text content = count)
   - #notif-dropdown (container for list)
*/

(function () {
  'use strict';

  if (!window.NService) {
    console.warn('NService not loaded yet');
    return;
  }
  const { showToast } = NService;

  function renderBadge(count) {
    try {
      const el = document.getElementById('notif-badge');
      if (!el) return;
      el.textContent = count > 0 ? String(count) : '';
      el.style.display = count > 0 ? 'inline-block' : 'none';
    } catch (e) { /* no-op */ }
  }

  function renderList(containerId, notifications) {
    const container = document.getElementById(containerId);
    if (!container) return;

    container.innerHTML = '';

    if (!notifications || notifications.length === 0) {
      const empty = document.createElement('div');
      empty.className = 'p-3 text-muted';
      empty.textContent = 'Tidak ada notifikasi';
      container.appendChild(empty);
      return;
    }

    notifications.forEach(n => {
      const item = document.createElement('div');
      item.className = 'notif-item d-flex align-items-start gap-2 p-2';
      item.dataset.notifId = n.id ?? n.notification_id ?? '';
      item.style.borderBottom = '1px solid rgba(0,0,0,0.04)';

      const left = document.createElement('div');
      left.style.flex = '1';

      const title = document.createElement('div');
      title.className = 'fw-semibold';
      title.textContent = n.message || n.title || 'Notifikasi';

      const meta = document.createElement('div');
      meta.className = 'small text-muted';
      meta.textContent = n.created_at ? new Date(n.created_at).toLocaleString() : '';

      left.appendChild(title);
      left.appendChild(meta);

      const btnWrap = document.createElement('div');
      const btn = document.createElement('button');
      btn.className = 'btn btn-sm btn-link';
      btn.textContent = n.read_at ? 'Sudah dibaca' : 'Tandai';
      btn.disabled = !!n.read_at;
      btn.addEventListener('click', async function (ev) {
        ev.preventDefault();
        if (btn.disabled) return;
        btn.disabled = true;
        try {
          const res = await NService.markNotificationAsRead(item.dataset.notifId);
          if (res.ok) {
            showToast('Notifikasi ditandai dibaca', 'success');
            btn.textContent = 'Sudah dibaca';
          } else {
            showToast(res.message || 'Gagal menandai notifikasi', 'error');
            btn.disabled = false;
          }
        } catch (e) {
          showToast('Terjadi kesalahan', 'error');
          btn.disabled = false;
        }
      });

      btnWrap.appendChild(btn);
      item.appendChild(left);
      item.appendChild(btnWrap);
      container.appendChild(item);
    });
  }

  // Expose
  window.NotificationRenderer = {
    renderBadge,
    renderList
  };

})();
