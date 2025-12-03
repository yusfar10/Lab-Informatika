
// /public/js/notification-page.js
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
/* notification-page.js
   Page glue that coordinates service + renderer.
   Expects DOM ids:
   - notif-badge
   - notif-dropdown-content
   - notif-refresh-btn (optional)
*/

(function () {
  'use strict';

  // defensive
  if (!window.NService || !window.NotificationRenderer) {
    console.warn('Notification libs not ready');
    return;
  }

  const { unreadCount, getNotifications, showToast } = NService;
  const { renderBadge, renderList } = NotificationRenderer;

  const badgeEl = document.getElementById('notif-badge');
  const dropdownContentId = 'notif-dropdown-content';

  async function loadBadge() {
    const res = await unreadCount();
    if (!res.ok) {
      // do not spam user with toasts on background polling; only log
      console.warn('Unread count error', res.message);
      return;
    }
    const cnt = (res.data && res.data.count) || (res.count) || 0;
    renderBadge(cnt);
  }

  async function loadList() {
    const res = await getNotifications();
    if (!res.ok) {
      showToast(res.message || 'Gagal memuat notifikasi', 'error');
      return;
    }
    // backend might return paginated object or array
    const list = Array.isArray(res.data) ? res.data : (res.data?.data ?? res.data ?? []);
    renderList(dropdownContentId, list);
    renderBadge(list.filter(i => !i.read_at).length);
  }

  // Poll unread count every 60s
  let pollTimer = null;
  function startPolling() {
    if (pollTimer) clearInterval(pollTimer);
    pollTimer = setInterval(loadBadge, 60000);
  }

  // Attach UI handlers
  const dropdownToggler = document.getElementById('notif-dropdown-toggle');
  if (dropdownToggler) {
    dropdownToggler.addEventListener('click', async function (e) {
      // open dropdown UI (assume your markup handles visibility)
      // when opening, load list
      await loadList();
    });
  }

  // initial
  loadBadge();
  startPolling();

  // optionally expose page actions
  window.NotificationPage = { loadBadge, loadList, startPolling, stop: () => clearInterval(pollTimer) };

})();
