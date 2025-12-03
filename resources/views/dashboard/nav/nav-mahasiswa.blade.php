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
                        <button id="markAllBtn" class="btn btn-sm btn-light">Tandai semua dibaca</button>
                    </div>

                    <div id="notifList">

                        @for ($i = 1; $i <= 8; $i++)
                            <div class="notif-item d-flex align-items-start p-2 mb-2"
                                style="
                                    background:#f8f9fa;
                                    border-radius:8px;
                            ">
                                <div class="flex-grow-1">
                                    <div style="font-size:14px; font-weight:600;">Dummy Notifikasi {{ $i }}
                                    </div>
                                    <div style="font-size:12px; color:#666;">Ini contoh konten pesan notifikasi.</div>
                                </div>
                            </div>
                        @endfor

                    </div>
                </div>
            </li>

        </ul>
    </div>
</nav>

<script>
    document.addEventListener("DOMContentLoaded", function () {

        const notifIcon = document.getElementById("notifIcon");
        const notifPanel = document.getElementById("notifPanel");
        const notifBadge = document.getElementById("notifBadge");
        const notifList  = document.getElementById("notifList");
        const markAllBtn = document.getElementById("markAllBtn");

        // Toggle buka/tutup panel
        notifIcon.addEventListener("click", function () {
            // Periksa apakah panel notif sedang tersembunyi
            const isHidden = notifPanel.style.display === "none" || notifPanel.style.display === "";
            // Tampilkan/Sembunyikan panel
            notifPanel.style.display = isHidden ? "block" : "none";
            // Jika ditampilkan, muat notifikasi
            if (isHidden) {
                loadNotifications();
            }
        });

        // Klik luar → tutup panel
        document.addEventListener("click", function (e) {
            // Pastikan pengecekan klik luar tidak mengganggu dropdown profil Bootstrap
            const isNotifIcon = notifIcon.contains(e.target);
            const isNotifPanel = notifPanel.contains(e.target);
            const isDropdown = e.target.closest('.dropdown-menu') || e.target.closest('.dropdown-toggle');
            
            if (!isNotifIcon && !isNotifPanel && !isDropdown) {
                notifPanel.style.display = "none";
            }
        });

        // Fetch unread count
        function loadUnread() {
            fetch("/api/v1/notification/unread-count", {
                headers: { "Authorization": "Bearer {{ session('token') }}" }
            })
            .then(res => res.json())
            .then(data => {
                if (data.count > 0) {
                    notifBadge.style.display = "inline-block";
                    notifBadge.textContent = data.count;
                } else {
                    notifBadge.style.display = "none";
                }
            })
            .catch(err => console.error(err));
        }

        // Load daftar notifikasi
        function loadNotifications() {
            fetch("/api/v1/notification", {
                headers: { "Authorization": "Bearer {{ session('token') }}" }
            })
            .then(res => res.json())
            .then(data => {
                notifList.innerHTML = "";

                if (data.data.length === 0) {
                    notifList.innerHTML = '<div class="text-center p-3 text-muted">Tidak ada notifikasi.</div>';
                    return;
                }

                data.data.forEach(item => {
                    notifList.innerHTML += `
                        <div class="notif-item p-2 mb-2"
                            style="background:${item.read_at ? '#ffffff' : '#f8f9fa'}; border-radius:8px; cursor:pointer;"
                            onclick="markAsRead(${item.id})">
                            <div style="font-size:14px; font-weight:600;">${item.message}</div>
                            <div style="font-size:12px; color:#555;">${item.created_at}</div>
                        </div>
                    `;
                });
            })
            .catch(err => {
                notifList.innerHTML = '<div class="text-center p-3 text-danger">Gagal memuat notifikasi.</div>';
                console.error(err);
            });
        }

        // Mark single
        window.markAsRead = function (id) {
            fetch(`/api/v1/notification/${id}`, {
                method: "PUT",
                headers: { "Authorization": "Bearer {{ session('token') }}" }
            })
            .then(() => {
                loadUnread();
                loadNotifications();
            })
            .catch(err => console.error(err));
        };

        // Mark all
        markAllBtn.addEventListener("click", function () {
            fetch("/api/v1/notification/mark-all-read", {
                method: "PUT",
                headers: { "Authorization": "Bearer {{ session('token') }}" }
            })
            .then(() => {
                loadUnread();
                loadNotifications();
            })
            .catch(err => console.error(err));
        });

        // load awal
        loadUnread();
        
        // Tambahkan event listener untuk memuat notifikasi saat panel dibuka
        notifIcon.addEventListener("click", function () {
            if (notifPanel.style.display === "block") {
                loadNotifications();
            }
        });

    });
</script>