<nav class="navbar navbar-fixed navbar-expand-lg px-4 ">
    <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="{{ asset('template-dashboard/img/LogoInformatics.png') }}" alt="Logo">
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse ms-auto" id="navbarNav">
        <ul class="navbar-nav d-flex align-items-center ms-auto">
            <li class="nav-item"><a class="nav-link" href="{{ route('mahasiswa.dashboard') }}">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('mahasiswa.booking-kelas') }}">Booking Class</a>
            </li>
            <li class="nav-item"><a class="nav-link" href="{{ route('mahasiswa.jadwal-kuliah') }}">Jadwal Kuliah</a>
            </li>
            <li class="nav-item"><a class="nav-link" href="{{ route('mahasiswa.riwayat') }}">Riwayat</a></li>

            <li class="nav-item dropdown">
                <a href="#" class="d-flex align-items-center" id="profileDropdown" data-bs-toggle="dropdown"
                    aria-expanded="false" style="cursor:pointer;">
                    <img src="{{ asset('template-dashboard/img/user.png') }}" class="rounded-circle ms-3" width="40"
                        alt="User"> 
                </a>

                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                    <li>
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>

            <li class="nav-item position-relative ms-3" style="cursor:pointer;">
                <img id="notifIcon" src="{{ asset('template-dashboard/img/Vector.png') }}" width="40"
                    class="notifikasi">

                <span id="notifBadge"
                    style="
                        position:absolute;
                        top:0;
                        right:0;
                        background:#ff3b3b;
                        color:white;
                        border-radius:50%;
                        font-size:10px;
                        padding:2px 6px;
                        display:none;
                    ">
                </span>

                <div id="notifPanel"
                    style="
                        display:none;
                        position:absolute;
                        top:50px;
                        right:0;
                        width:330px;
                        max-height:420px;
                        overflow-y:auto;
                        background:white;
                        border-radius:12px;
                        box-shadow:0 4px 12px rgba(0,0,0,0.15);
                        z-index:9999;
                        padding:10px;
                    ">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <strong>Notifikasi</strong>
                        <div class="d-flex gap-1">
                            <a href="{{ route('mahasiswa.notifikasi') }}" class="btn btn-sm btn-primary" style="text-decoration:none;">ALL</a>
                            <button id="markAllBtn" class="btn btn-sm btn-light">Tandai semua dibaca</button>
                        </div>
                    </div>

                    <div id="notifList">
                        <!-- Notifications will be loaded dynamically here -->
                    </div>
                </div>
            </li>

        </ul>
    </div>
</nav>

<script>
// Global notification functions (available immediately)
window.notificationUtils = {
    refresh: function(delay = 500) {
        if (typeof window.refreshNotifications === 'function') {
            window.refreshNotifications(delay);
        }
    },
    forceRefresh: function() {
        // Force immediate refresh
        if (typeof window.loadUnreadNotifications === 'function') {
            window.loadUnreadNotifications();
        }
        if (typeof window.loadNotificationsList === 'function') {
            window.loadNotificationsList();
        }
    }
};

document.addEventListener("DOMContentLoaded", function () {

    const notifIcon = document.getElementById("notifIcon");
    const notifPanel = document.getElementById("notifPanel");
    const notifBadge = document.getElementById("notifBadge");
    const notifList  = document.getElementById("notifList");
    const markAllBtn = document.getElementById("markAllBtn");
    
    // Check if elements exist
    if (!notifIcon || !notifPanel || !notifBadge || !notifList) {
        console.warn('Notification elements not found');
        return;
    }
    
    // Check markAllBtn separately karena bisa null di beberapa halaman
    if (!markAllBtn) {
        console.warn('markAllBtn not found - will skip mark all functionality');
    }

    // Toggle buka/tutup panel
    notifIcon.addEventListener("click", function () {
        notifPanel.style.display =
            notifPanel.style.display === "none" ? "block" : "none";
        // Load notifications when panel is opened
        if (notifPanel.style.display === "block") {
            loadNotifications();
        }
    });

    // Klik luar → tutup panel
    document.addEventListener("click", function (e) {
        if (notifIcon && notifPanel && !notifIcon.contains(e.target) && !notifPanel.contains(e.target)) {
            notifPanel.style.display = "none";
        }
    });

    // Get CSRF Token
    function getCSRFToken() {
        return document.querySelector('meta[name="csrf-token"]')?.content || '';
    }

    // Fetch unread count (optimasi: fetch lebih cepat)
    async function loadUnread() {
        try {
            const res = await fetch("/api/notification/unread-count", {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    "Cache-Control": "no-cache"
                },
                credentials: "same-origin",
                cache: "no-store" // Tidak cache untuk data real-time
            });
            
            if (!res.ok) return;
            
            const data = await res.json();
            if (data.success && data.count > 0) {
                notifBadge.style.display = "inline-block";
                notifBadge.textContent = data.count;
            } else {
                notifBadge.style.display = "none";
            }
        } catch (err) {
            // Silent fail untuk performa
            // console.error("Error loading unread count:", err);
        }
    }

    // Load daftar notifikasi
    async function loadNotifications() {
        try {
            // Add cache busting to prevent stale data
            const timestamp = new Date().getTime();
            const res = await fetch(`/api/notification?t=${timestamp}`, {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    "Cache-Control": "no-cache"
                },
                credentials: "same-origin"
            });
            const data = await res.json();
            notifList.innerHTML = "";

            if (data.success && data.data && data.data.length > 0) {
                // Sort by notification_time descending (newest first)
                const sorted = data.data.sort((a, b) => {
                    const timeA = new Date(a.notification_time || a.created_at);
                    const timeB = new Date(b.notification_time || b.created_at);
                    return timeB - timeA;
                });
                
                // Ambil hanya 5 notifikasi terbaru
                const latestNotifications = sorted.slice(0, 5);
                const totalCount = sorted.length;
                const hasMore = totalCount > 5;
                
                latestNotifications.forEach(item => {
                    const isUnread = !item.is_read;
                    // Unread = hijau, Read = abu-abu (sama dengan halaman notifikasi)
                    const bgColor = isUnread ? '#d1f2eb' : '#e9ecef';
                    const borderColor = isUnread ? '#27ae60' : '#6c757d';
                    const borderStyle = `border-left: 4px solid ${borderColor};`;
                    const boxShadow = isUnread ? 'box-shadow: rgba(39, 174, 96, 0.1) 0 3px 6px;' : 'box-shadow: rgba(0,0,0,0.04) 0 3px 6px;';
                    const time = new Date(item.notification_time || item.created_at).toLocaleString("id-ID", {
                        year: "numeric",
                        month: "short",
                        day: "numeric",
                        hour: "2-digit",
                        minute: "2-digit"
                    });
                    // Indicator untuk unread (dot hijau) atau read (dot abu-abu)
                    const indicatorColor = isUnread ? '#27ae60' : '#6c757d';
                    const unreadIndicator = `
                        <span style="display:inline-block; width:10px; height:10px; background:${indicatorColor}; border-radius:50%; margin-right:8px; vertical-align:middle;" title="${isUnread ? 'Belum dibaca' : 'Sudah dibaca'}"></span>
                    `;
                    
                    notifList.innerHTML += `
                        <div class="notif-item p-2 mb-2"
                             style="background:${bgColor}; border-radius:8px; cursor:pointer; ${borderStyle} ${boxShadow}; transition: all 0.2s ease;"
                             onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='rgba(0,0,0,0.1) 0 4px 8px';"
                             onmouseout="this.style.transform=''; this.style.boxShadow='${boxShadow}';"
                             onclick="markAsRead(${item.notification_id})">
                            <div style="font-size:14px; font-weight:600; display:flex; align-items:center;">
                                ${unreadIndicator}
                                <span>${item.pesan || item.message || 'Notifikasi'}</span>
                            </div>
                            <div style="font-size:12px; color:#555; margin-left:18px;">${time}</div>
                        </div>
                    `;
                });
                
                // Tampilkan pesan jika ada lebih dari 5 notifikasi
                if (hasMore) {
                    const remainingCount = totalCount - 5;
                    notifList.innerHTML += `
                        <div class="text-center p-2 mt-2" style="border-top: 1px solid #e0e0e0;">
                            <a href="{{ route('mahasiswa.notifikasi') }}" 
                               style="color: #007bff; text-decoration: none; font-size: 13px; font-weight: 600;">
                                Lihat ${remainingCount} notifikasi lainnya
                            </a>
                        </div>
                    `;
                }
            } else {
                notifList.innerHTML = `
                    <div class="text-center p-3 text-muted" style="font-size:14px;">
                        Tidak ada notifikasi
                    </div>
                `;
            }
        } catch (err) {
            console.error("Error loading notifications:", err);
            notifList.innerHTML = `
                <div class="text-center p-3 text-danger" style="font-size:14px;">
                    Gagal memuat notifikasi
                </div>
            `;
        }
    }

    // Mark single
    window.markAsRead = async function (id) {
        try {
            await fetch(`/api/notification/${id}`, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": getCSRFToken()
                },
                credentials: "same-origin"
            });
            loadUnread();
            loadNotifications();
        } catch (err) {
            console.error("Error marking as read:", err);
        }
    };

    // Mark all (dengan check null)
    if (markAllBtn) {
        markAllBtn.addEventListener("click", async function () {
            try {
                const res = await fetch("/api/notification/mark-all-read", {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": getCSRFToken()
                    },
                    credentials: "same-origin"
                });
                
                // Check if response is ok
                if (!res.ok) {
                    throw new Error(`HTTP error! status: ${res.status}`);
                }
                
                const data = await res.json();
                if (data && data.success) {
                    // Refresh immediately
                    await loadUnread();
                    await loadNotifications();
                } else {
                    console.error("Failed to mark all as read:", data);
                    alert(data.message || "Gagal menandai semua notifikasi sebagai dibaca");
                }
            } catch (err) {
                console.error("Error marking all as read:", err);
                alert("Terjadi error saat menandai semua notifikasi sebagai dibaca: " + err.message);
            }
        });
    }
    
    // Expose function for external refresh (optimasi: delay minimal)
    window.refreshNotifications = function(delay = 0) {
        if (delay > 0) {
            setTimeout(() => {
                loadUnread();
                loadNotifications();
            }, delay);
        } else {
            // Immediate refresh tanpa delay
            loadUnread();
            loadNotifications();
        }
    };
    
    // Expose individual functions untuk akses dari luar
    window.loadUnreadNotifications = loadUnread;
    window.loadNotificationsList = loadNotifications;

    // load awal
    loadUnread();
    loadNotifications();
    
    // Auto-refresh notifications every 15 seconds (lebih cepat dari 30 detik)
    setInterval(() => {
        loadUnread();
        // Only refresh list if panel is open
        if (notifPanel && notifPanel.style.display !== 'none') {
            loadNotifications();
        }
    }, 15000); // Kurangi dari 30 detik ke 15 detik untuk update lebih cepat
});
</script>
