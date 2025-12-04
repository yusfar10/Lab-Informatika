<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // GET /api/notification
    public function index(Request $request)
    {
        $userId = auth()->id();

        $query = Notification::where('user_id', $userId);

        // Filter by category if provided
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by status (unread/read)
        if ($request->filled('status')) {
            if ($request->status === 'unread') {
                $query->where('is_read', false);
            } elseif ($request->status === 'read') {
                $query->where('is_read', true);
            }
        }

        // Optimasi: hanya ambil field yang diperlukan dan limit lebih kecil untuk navbar
        $notifications = $query->select([
                'notification_id',
                'user_id',
                'pesan',
                'notification_time',
                'is_read',
                'category',
                'type',
                'created_at'
            ])
            ->orderBy('notification_time', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(10) // Hanya ambil 10 terbaru untuk performa
            ->get();

        return response()->json([
            'success' => true,
            'data' => $notifications
        ]);
    }

    // PUT /api/notification/{id}
    public function update(Request $request, $id)
    {
        $userId = auth()->id();

        $notif = Notification::where('notification_id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$notif) {
            return response()->json([
                'success' => false,
                'message' => 'Notifikasi tidak ditemukan'
            ], 404);
        }

        $notif->update([
            'is_read' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi ditandai sebagai dibaca'
        ]);
    }

    // PUT /api/notification/mark-all-read
    public function markAllRead(Request $request)
    {
        try {
            $userId = auth()->id();
            
            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak terautentikasi'
                ], 401);
            }

            $updated = Notification::where('user_id', $userId)
                ->where('is_read', false)
                ->update(['is_read' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Semua notifikasi ditandai sebagai dibaca',
                'updated_count' => $updated
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error marking all notifications as read', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menandai semua notifikasi sebagai dibaca: ' . $e->getMessage()
            ], 500);
        }
    }

    // GET /api/notification/unread-count
    public function unreadCount()
    {
        $userId = auth()->id();

        // Optimasi: langsung count tanpa select semua field
        $count = Notification::where('user_id', $userId)
            ->where('is_read', false)
            ->count('notification_id'); // Count dengan primary key lebih cepat

        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }
}

