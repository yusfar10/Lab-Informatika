<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // GET /api/v1/notification
    public function index(Request $request)
    {
        $userId = auth()->id();

        $notifications = Notification::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $notifications
        ]);
    }

    // PUT /api/v1/notification/{id}
    public function markAsRead($id)
    {
        $notif = Notification::find($id);

        if (!$notif) {
            return response()->json(['success' => false], 404);
        }

        $notif->update([
            'read_at' => now()
        ]);

        return response()->json(['success' => true]);
    }

    // PUT /api/v1/notification/mark-all-read
    public function markAllRead()
    {
        $userId = auth()->id();

        Notification::where('user_id', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => 'Semua notifikasi ditandai sebagai dibaca'
        ]);
    }

    // GET /api/v1/notification/unread-count
    public function unreadCount()
    {
        $userId = auth()->id();

        $count = Notification::where('user_id', $userId)
            ->whereNull('read_at')
            ->count();

        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }
}

