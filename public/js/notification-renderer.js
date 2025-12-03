// /public/js/notification-renderer.js
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
