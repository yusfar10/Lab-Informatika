<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\Laboratorium;
use App\Models\JadwalKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Get dashboard statistics.
     * Returns total bookings, favorite lab, and bookings this month.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function stats()
    {
        try {
            // Get total bookings count
            $totalBookings = Bookings::count();

            // Get bookings count for current month
            $bookingsThisMonth = Bookings::whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', Carbon::now()->month)
                ->count();

            // Get favorite/top lab (most booked)
            $topLab = Bookings::select('jadwal_kelas.room_id', 'laboratorium.room_name', DB::raw('COUNT(bookings.booking_id) as booking_count'))
                ->join('jadwal_kelas', 'bookings.class_id', '=', 'jadwal_kelas.class_id')
                ->join('laboratorium', 'jadwal_kelas.room_id', '=', 'laboratorium.room_id')
                ->groupBy('jadwal_kelas.room_id', 'laboratorium.room_name')
                ->orderByDesc('booking_count')
                ->first();

            return response()->json([
                'success' => true,
                'data' => [
                    'total_bookings' => $totalBookings,
                    'bookings_this_month' => $bookingsThisMonth,
                    'top_lab' => [
                        'room_id' => $topLab->room_id ?? null,
                        'room_name' => $topLab->room_name ?? 'Belum ada data',
                        'booking_count' => $topLab->booking_count ?? 0,
                    ],
                ],
                'message' => 'Dashboard statistics retrieved successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve dashboard statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
