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
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get()
            ->map(function ($booking) {
                return [
                    'booking_id' => $booking->booking_id,
                    'booking_time' => $booking->booking_time,
                    'booking_time_human' => $booking->created_at_human,
                    'created_at' => $booking->created_at,
                    'user' => [
                        'id' => $booking->user->id ?? null,
                        'name' => $booking->user->name ?? 'Unknown',
                        'username' => $booking->user->username ?? 'Unknown',
                        'kelas' => $booking->user->kelas ?? 'Unknown',
                    ],
                    'jadwal_kelas' => [
                        'class_id' => $booking->jadwalKelas->class_id ?? null,
                        'class_name' => $booking->jadwalKelas->class_name ?? 'Unknown',
                        'penanggung_jawab' => $booking->jadwalKelas->penanggung_jawab ?? 'Unknown',
                        'start_time' => $booking->jadwalKelas->start_time ?? null,
                        'end_time' => $booking->jadwalKelas->end_time ?? null,
                        'laboratorium' => [
                            'room_id' => $booking->jadwalKelas->laboratorium->room_id ?? null,
                            'room_name' => $booking->jadwalKelas->laboratorium->room_name ?? 'Unknown',
                        ],
                    ],
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
