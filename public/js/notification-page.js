// public/js/notification-page.js

// waktu human readable (Indonesia)
function timeAgo(iso) {
    if (!iso) return '';
    const now = new Date();
    const d = new Date(iso);
    const s = Math.floor((now - d) / 1000);
    if (s < 60) return `${s} detik lalu`;
    const m = Math.floor(s / 60);
    if (m < 60) return `${m} menit lalu`;
    const h = Math.floor(m / 60);
    if (h < 24) return `${h} jam lalu`;
    const day = Math.floor(h / 24);
    if (day < 30) return `${day} hari lalu`;
    const mon = Math.floor(day / 30);
    if (mon < 12) return `${mon} bulan lalu`;
    const yr = Math.floor(mon / 12);
    return `${yr} tahun lalu`;
}

// map category to color
function categoryColor(c) {
    return {
        booking: '#0d6efd',
        pengumuman: '#ffc107',
        peringatan: '#dc3545',
        info: '#17a2b8'
    }[c] || '#6c757d';
}

function el(id) { return document.getElementById(id); }

async function renderNotifications(filters = {}) {
    const listEl = el('notificationList');
    const loadingEl = el('loadingState');

    // show loading
    listEl.innerHTML = '';
    loadingEl.style.display = 'block';

    try {
        const res = await NotificationService.fetchNotifications(filters);
        loadingEl.style.display = 'none';

        // Laravel paginate -> res.data
        const items = res?.data ?? res ?? [];

        if (!items.length) {
            listEl.innerHTML = `<div class="text-center mt-4"><p class="text-muted">Tidak ada notifikasi</p></div>`;
            return;
        }

        // render
        const frag = document.createDocumentFragment();
        items.forEach(item => {
            const div = document.createElement('div');
            div.className = `item-notif ${item.read_at ? '' : 'unread'}`;
            div.innerHTML = `
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="badge-category" style="background:${categoryColor(item.category)}">${item.category || 'INFO'}</span>
                        <span class="fw-semibold">${item.title || ''}</span>
                        <p class="text-muted mb-0">${item.message || ''}</p>
                    </div>
                    <div class="text-end">
                        <div class="text-muted small">${timeAgo(item.created_at || item.createdAt || item.created)}</div>
                        <div class="mt-2">
                            <input type="checkbox" class="form-check-input mark-read-checkbox" data-id="${item.id}" ${item.read_at ? 'checked' : ''}>
                        </div>
                    </div>
                </div>
            `;

            // checkbox listener
            const cb = div.querySelector('.mark-read-checkbox');
            cb.addEventListener('change', async (e) => {
                const id = e.target.dataset.id;
                try {
                    await NotificationService.markAsRead(id);
                    // optimistic UI
                    div.classList.remove('unread');
                    e.target.checked = true;
                } catch (err) {
                    console.error(err);
                    alert('Gagal menandai notifikasi. Cek console.');
                    e.target.checked = !e.target.checked;
                }
            });

            frag.appendChild(div);
        });

        listEl.appendChild(frag);

    } catch (err) {
        loadingEl.style.display = 'none';
        console.error(err);
        listEl.innerHTML = `<div class="text-center mt-4"><p class="text-danger">Gagal memuat notifikasi. Refresh halaman.</p></div>`;
    }
}

// event hookup
document.addEventListener('DOMContentLoaded', () => {
    const cat = el('filterCategory');
    const status = el('filterStatus');
    const markAll = el('markAllBtn');

    const doLoad = () => {
        const filters = { per_page: 50 };
        if (cat && cat.value) filters.category = cat.value;
        if (status && status.value) filters.status = status.value;
        renderNotifications(filters);
    };

    // initial load
    doLoad();

    if (cat) cat.addEventListener('change', doLoad);
    if (status) status.addEventListener('change', doLoad);

    if (markAll) {
        markAll.addEventListener('click', async () => {
            if (!confirm('Tandai semua notifikasi sebagai dibaca?')) return;
            try {
                await NotificationService.markAllAsRead();
                doLoad();
            } catch (err) {
                console.error(err);
                alert('Gagal menandai semua dibaca.');
            }
        });
    }
});
