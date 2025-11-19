<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Bookings $bookings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bookings $bookings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bookings $bookings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bookings $bookings)
    {
        //
    }

    /**
     * Get latest 3 bookings with human readable time.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function latest()
    {
        try {
            $latestBookings = Bookings::with([
                'user:id,name,username,kelas',
                'jadwalKelas:class_id,class_name,room_id,start_time,end_time,penanggung_jawab',
                'jadwalKelas.laboratorium:room_id,room_name'
            ])
            ->whereHas('user', function ($query) {
                $query->whereNotNull('kelas')
                      ->where('kelas', '!=', '');
            })
            ->whereHas('jadwalKelas', function ($query) {
                $query->whereNotNull('class_name')
                      ->whereNotNull('room_id');
            })
            ->whereHas('jadwalKelas.laboratorium')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get()
            ->map(function ($booking) {
                // User sudah pasti ada dan memiliki kelas (karena whereHas filter)
                $user = $booking->user;
                $userData = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'username' => $user->username,
                    'kelas' => $user->kelas,
                ];
                
                // Jadwal kelas sudah pasti ada dan memiliki laboratorium (karena whereHas filter)
                $jadwalKelas = $booking->jadwalKelas;
                $laboratorium = $jadwalKelas->laboratorium;
                
                $jadwalData = [
                    'class_id' => $jadwalKelas->class_id,
                    'class_name' => $jadwalKelas->class_name,
                    'penanggung_jawab' => $jadwalKelas->penanggung_jawab,
                    'start_time' => $jadwalKelas->start_time,
                    'end_time' => $jadwalKelas->end_time,
                    'laboratorium' => [
                        'room_id' => $laboratorium->room_id,
                        'room_name' => $laboratorium->room_name,
                    ],
                ];
                
                return [
                    'booking_id' => $booking->booking_id,
                    'booking_time' => $booking->booking_time,
                    'booking_time_human' => $booking->created_at_human,
                    'created_at' => $booking->created_at,
                    'user' => $userData,
                    'jadwal_kelas' => $jadwalData,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $latestBookings,
                'message' => 'Latest bookings retrieved successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve latest bookings',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
