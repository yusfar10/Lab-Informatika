<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    // GET /api/v1/notification
    public function index(Request $request)
    {
        $userId = auth()->id();

        $query = Notification::where('user_id', $userId)->orderBy('created_at', 'desc');

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status') && $request->status === 'unread') {
            // menggunakan kolom read_at (null = unread)
            $query->whereNull('read_at');
        }

        $perPage = (int) ($request->per_page ?? 10);

        $paged = $query->paginate($perPage);

        return response()->json($paged);
    }

    // PUT /api/v1/notification/{id}
    public function markAsRead($id)
    {
        $userId = auth()->id();

        $notif = Notification::where('id', $id)->where('user_id', $userId)->first();

        if (!$notif) {
            return response()->json(['success' => false, 'message' => 'Notifikasi tidak ditemukan'], 404);
        }

        $notif->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    // PUT /api/v1/notification/mark-all-read
    public function markAllRead()
    {
        $userId = auth()->id();

        Notification::where('user_id', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['success' => true, 'message' => 'Semua notifikasi ditandai sebagai dibaca']);
    }

    // GET /api/v1/notification/unread-count
    public function unreadCount()
    {
        $userId = auth()->id();

        $count = Notification::where('user_id', $userId)
            ->whereNull('read_at')
            ->count();

        return response()->json(['success' => true, 'count' => $count]);
    }
}
