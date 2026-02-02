<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Profil Pengguna</title>
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            background: #f0f4f8;
            font-family: 'Poppins', sans-serif;
            flex-direction: column;
            min-height: 100vh;
        }

        #main-wrapper {
            flex: 1;
        }

        .status {
            padding-top: 30px;
            justify-content: space-between;
            display: flex;
        }

        .u-notifikasi {
            padding-top: 1px;
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <!-- NAVBAR -->
    <nav class="bg-[#1F2A44] text-white px-4 sm:px-6 md:px-8 py-4 shadow">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between">

                <div class="flex items-center space-x-3">
                    <img src="{{ asset('template-dashboard/img/LogoInformatics.png') }}" class="w-10" alt="">
                    <span class="font-bold text-lg">ADMIN PANEL</span>
                </div>

                <ul class="hidden md:flex space-x-8 font-semibold">
                    <li><a href="{{ route('mahasiswa.dashboard') }}" class="hover:text-gray-300">Home</a></li>
                    <li><a href="{{ route('mahasiswa.booking-kelas') }}" class="hover:text-gray-300">Booking Class</a>
                    </li>
                    <li><a href="{{ route('mahasiswa.jadwal-kuliah') }}" class="hover:text-gray-300">Jadwal Kuliah</a>
                    </li>
                    <li><a href="{{ route('mahasiswa.riwayat') }}" class="hover:text-gray-300">Riwayat</a></li>
                    <li class="nav-item position-relative ms-3" style="cursor:pointer;">
                        <img id="notifIcon" src="{{ asset('template-dashboard/img/Vector.png') }}" width="18"
                            class="notifikasi u-notifikasi">

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
                        background:rgb(150, 150, 150);
                        border-radius:12px;
                        box-shadow:0 4px 12px rgba(0,0,0,0.15);
                        z-index:9999;
                        padding:10px;
                    ">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <strong>Notifikasi</strong>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('mahasiswa.notifikasi') }}" class="btn btn-sm btn-primary"
                                        style="text-decoration:none;">ALL</a>
                                    <button id="markAllBtn" class="btn btn-sm btn-light">Tandai semua dibaca</button>
                                </div>
                            </div>

                            <div id="notifList">
                                <!-- Notifications will be loaded dynamically here -->
                            </div>
                        </div>
                    </li>
                </ul>

                <div class="md:hidden">
                    <button id="menu-button" type="button"
                        class="text-white hover:text-gray-300 focus:outline-none focus:text-gray-300">
                        <svg class="h-6 w-6 block" id="menu-icon-open" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                        <svg class="h-6 w-6 hidden" id="menu-icon-close" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden mt-4">
            <ul class="flex flex-col space-y-2 font-semibold border-t border-gray-700 pt-4">
                <li><a href="{{ route('mahasiswa.dashboard') }}"
                        class="block px-3 py-2 rounded-md text-base hover:bg-[#2A3756]">Home</a></li>
                <li><a href="{{ route('mahasiswa.booking-kelas') }}"
                        class="block px-3 py-2 rounded-md text-base hover:bg-[#2A3756]">Ruang</a></li>
                <li><a href="{{ route('mahasiswa.jadwal-kuliah') }}"
                        class="block px-3 py-2 rounded-md text-base hover:bg-[#2A3756]">User</a></li>
                <li><a href="{{ route('mahasiswa.riwayat') }}"
                        class="block px-3 py-2 rounded-md text-base hover:bg-[#2A3756]">Booking</a></li>
                <li><a href="#" class="block px-3 py-2 rounded-md text-base hover:bg-[#2A3756]">Laporan</a></li>
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
                        background:rgb(150, 150, 150);
                        border-radius:12px;
                        box-shadow:0 4px 12px rgba(0,0,0,0.15);
                        z-index:9999;
                        padding:10px;
                    ">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <strong>Notifikasi</strong>
                            <div class="d-flex gap-1">
                                <a href="{{ route('mahasiswa.notifikasi') }}" class="btn btn-sm btn-primary"
                                    style="text-decoration:none;">ALL</a>
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

    <!-- CONTENT WRAPPER -->
    <div class="max-w-6xl mx-auto mt-10" id="main-wrapper">

        <h1 class="text-3xl font-bold text-gray-800">Profil Pengguna</h1>
        <p class="text-gray-500">Informasi akun & pengaturan pribadi</p>

        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- LEFT CARD -->
            <div class="bg-white p-6 rounded-xl shadow">
                <div class="flex items-center space-x-5">
                    <img src="{{ asset('template-dashboard/img/klmp1.png') }}"
                        class="w-28 h-28 rounded-full border shadow">
                    <div>
                        <h2 class="font-bold text-3xl">Yusuf Alim</h2>
                        <p class="text-xl text-gray-500 -mt-1">Administrator</p>
                    </div>
                </div>

                <div class="mt-6 status">
                    <p class="font-semibold text-gray-700">Status</p>
                    <p class="text-green-600 font-bold">Online</p>
                </div>
            </div>

            <!-- RIGHT CARD -->
            <div class="bg-white p-6 rounded-xl shadow">
                <h2 class="font-bold text-xl mb-4">Info Akun</h2>

                <div class="grid grid-cols-2 gap-y-3">
                    <p class="text-gray-600">Nama Lengkap</p>
                    <p class="font-semibold text-gray-800">Yusuf Alim</p>

                    <p class="text-gray-600">Nomor HP</p>
                    <p class="font-semibold text-gray-800">0123 4567 8910</p>

                    <p class="text-gray-600">Semester</p>
                    <p class="font-semibold text-gray-800">5</p>

                    <p class="text-gray-600">Kelas</p>
                    <p class="font-semibold text-gray-800">A</p>
                </div>
            </div>

        </div>

        <!-- BUTTON GROUP -->
        <div class="bg-white p-6 rounded-xl shadow mt-6 flex items-center space-x-4">
            <button class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Save</button>

            <button class="px-6 py-2 border rounded-lg hover:bg-gray-100">
                Activity Log
            </button>

            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Logout
                </button>
            </form>
        </div>

    </div>

    <!-- FOOTER -->
    <footer class="bg-[#1F2A44] text-gray-300 text-center py-4 mt-10">
        Copyright © Kelompok 1 - Manajemen Proyek
    </footer>
    <script>
        document.getElementById('menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            const iconOpen = document.getElementById('menu-icon-open');
            const iconClose = document.getElementById('menu-icon-close');

            // Toggle visibility
            mobileMenu.classList.toggle('hidden');

            // Toggle icon
            iconOpen.classList.toggle('hidden');
            iconClose.classList.toggle('hidden');
        });

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

        document.addEventListener("DOMContentLoaded", function() {

            const notifIcon = document.getElementById("notifIcon");
            const notifPanel = document.getElementById("notifPanel");
            const notifBadge = document.getElementById("notifBadge");
            const notifList = document.getElementById("notifList");
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
            notifIcon.addEventListener("click", function() {
                notifPanel.style.display =
                    notifPanel.style.display === "none" ? "block" : "none";
                // Load notifications when panel is opened
                if (notifPanel.style.display === "block") {
                    loadNotifications();
                }
            });

            // Klik luar → tutup panel
            document.addEventListener("click", function(e) {
                if (notifIcon && notifPanel && !notifIcon.contains(e.target) && !notifPanel.contains(e
                        .target)) {
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
                            const bgColor = isUnread ? '#f4f4f4' : '#e9ecef';
                            const borderColor = isUnread ? '#27ae60' : '#6c757d';
                            const borderStyle = `border-left: 4px solid ${borderColor};`;
                            const boxShadow = isUnread ?
                                'box-shadow: rgba(39, 174, 96, 0.1) 0 3px 6px;' :
                                'box-shadow: rgba(0,0,0,0.04) 0 3px 6px;';
                            const time = new Date(item.notification_time || item.created_at)
                                .toLocaleString("id-ID", {
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
                                <div style="font-size:12px; color:#000; margin-left:18px;">${time}</div>
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
            window.markAsRead = async function(id) {
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
                markAllBtn.addEventListener("click", async function() {
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
                        alert("Terjadi error saat menandai semua notifikasi sebagai dibaca: " + err
                            .message);
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

</body>

</html>
