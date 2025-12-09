<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notification Service Demo</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="/js/notification-service.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fc;
            padding: 30px;
        }

        h1 {
            margin-bottom: 10px;
        }

        .badge {
            display: inline-block;
            background: #dc3545;
            padding: 4px 10px;
            border-radius: 16px;
            color: white;
            font-size: 13px;
            margin-left: 8px;
        }

        .toolbar {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        button {
            background: #4a6cf7;
            color: white;
            border: none;
            padding: 10px 14px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            margin-right: 10px;
            transition: 0.2s;
        }

        button:hover {
            background: #2546d2;
        }

        .card {
            background: white;
            padding: 16px;
            border-radius: 10px;
            margin-bottom: 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0px 2px 4px rgba(0,0,0,0.05);
        }

        .category {
            display: inline-block;
            padding: 4px 8px;
            font-size: 12px;
            border-radius: 6px;
            margin-bottom: 6px;
            color: white;
        }

        .cat-info { background: #0d6efd; }
        .cat-warning { background: #ffc107; color:black; }
        .cat-danger { background: #dc3545; }

        .time {
            font-size: 12px;
            color: gray;
        }

        .loading {
            text-align: center;
            padding: 20px;
            font-size: 14px;
            color: #6c757d;
        }

        .empty {
            padding: 20px;
            text-align: center;
            color: #6c757d;
        }

        pre {
            background: #282c34;
            color: #d4d4d4;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            overflow-x: auto;
        }
    </style>
</head>
<body>

    <h1>📢 Notification Service Demo</h1>

    <div>
        Unread: <span id="notifBadge" class="badge">0</span>
    </div>

    <div class="toolbar">
        <button onclick="fetchData()">🔄 Fetch Notifikasi</button>
        <button onclick="markAll()">✔ Mark Semua Dibaca</button>
    </div>

    <div id="notifContainer"></div>

    <h3>Debug Response</h3>
    <pre id="jsonViewer">{}</pre>

<script>
    // =====================
    // Human readable time
    // =====================
    function timeAgo(dateString) {
        const date = new Date(dateString);
        const seconds = Math.floor((new Date() - date) / 1000);

        const intervals = {
            tahun: 31536000,
            bulan: 2592000,
            minggu: 604800,
            hari: 86400,
            jam: 3600,
            menit: 60
        };

        for (let key in intervals) {
            const value = Math.floor(seconds / intervals[key]);
            if (value > 0) return `${value} ${key} lalu`;
        }

        return "Baru saja";
    }

    // =====================
    // FETCH DATA
    // =====================
    async function fetchData() {
        const container = document.getElementById("notifContainer");
        container.innerHTML = `<div class="loading">Memuat notifikasi...</div>`;

        const result = await NotificationService.getNotifications();

        document.getElementById("jsonViewer").textContent = JSON.stringify(result, null, 2);

        if (result.data.length === 0) {
            container.innerHTML = `<div class="empty">Tidak ada notifikasi</div>`;
            return;
        }

        renderCards(result.data);
        updateBadge();
    }

    // =====================
    // RENDER CARD
    // =====================
    function renderCards(list) {
        const container = document.getElementById("notifContainer");
        container.innerHTML = "";

        list.forEach(item => {
            let color = "cat-info";
            if (item.category === "warning") color = "cat-warning";
            if (item.category === "danger") color = "cat-danger";

            container.innerHTML += `
                <div class="card">
                    <div class="category ${color}">${item.category}</div>
                    <p>${item.message}</p>
                    <div class="time">${timeAgo(item.created_at)}</div>
                    <button onclick="markOne(${item.id})">Tandai Dibaca</button>
                </div>
            `;
        });
    }

    // =====================
    // MARK ONE
    // =====================
    async function markOne(id) {
        await NotificationService.markAsRead(id);
        fetchData();
    }

    // =====================
    // MARK ALL
    // =====================
    async function markAll() {
        await NotificationService.markALLAsRead();
        fetchData();
    }

    // =====================
    // BADGE
    // =====================
    async function updateBadge() {
        const { unread } = await NotificationService.getUnreadCount();
        document.getElementById("notifBadge").innerText = unread;
    }

    updateBadge();
</script>

</body>
</html>
