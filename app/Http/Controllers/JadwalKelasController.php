<?php

namespace App\Http\Controllers;

use App\Models\JadwalKelas;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JadwalKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get filter parameters
        $tanggal = $request->input('tanggal', date('Y-m-d'));
        $roomId = $request->input('room_id');
        $hanyaTersedia = $request->boolean('hanya_tersedia', false);
        $perMinggu = $request->boolean('per_minggu', false); // Default: per hari

        $selectedDate = Carbon::parse($tanggal);
        
        // Determine date range based on per_minggu flag
        if ($perMinggu) {
            // Calculate week start (Monday) and end (Friday)
            $weekStart = $selectedDate->copy()->startOfWeek(Carbon::MONDAY);
            $weekEnd = $weekStart->copy()->endOfWeek(Carbon::FRIDAY);
            $dateStart = $weekStart->startOfDay();
            $dateEnd = $weekEnd->endOfDay();
        } else {
            // Single day only
            $dateStart = $selectedDate->copy()->startOfDay();
            $dateEnd = $selectedDate->copy()->endOfDay();
        }

        // Build query
        $query = JadwalKelas::with('laboratorium:room_id,room_name')
            ->whereBetween('start_time', [$dateStart, $dateEnd])
            ->where('status', 'schedule'); // Only active schedules

        // Filter by room_id if provided
        if ($roomId) {
            $query->where('room_id', $roomId);
        }

        // Get schedules
        $schedules = $query->get();

        // Format response
        $formattedSchedules = $schedules->map(function ($schedule) {
            $startTime = Carbon::parse($schedule->start_time);
            $endTime = Carbon::parse($schedule->end_time);
            
            // Carbon dayOfWeek: 0 = Sunday, 1 = Monday, ..., 6 = Saturday
            // We need: 1 = Monday, 2 = Tuesday, ..., 5 = Friday
            $dayOfWeek = $startTime->dayOfWeek;
            $dayIndex = $dayOfWeek === 0 ? 7 : $dayOfWeek; // Convert Sunday (0) to 7, keep others as is
            // Now: 1 = Monday, 2 = Tuesday, ..., 7 = Sunday
            // Filter only Monday-Friday (1-5)
            if ($dayIndex < 1 || $dayIndex > 5) {
                return null; // Skip weekends
            }
            
            return [
                'class_id' => $schedule->class_id,
                'class_name' => $schedule->class_name,
                'room_id' => $schedule->room_id,
                'room_name' => $schedule->laboratorium->room_name ?? 'N/A',
                'penanggung_jawab' => $schedule->penanggung_jawab,
                'start_time' => $schedule->start_time,
                'end_time' => $schedule->end_time,
                'day' => $startTime->format('l'), // Day name (Monday, Tuesday, etc.)
                'day_index' => $dayIndex, // 1 = Monday, 2 = Tuesday, ..., 5 = Friday
                'time_start' => $startTime->format('H:i'),
                'time_end' => $endTime->format('H:i'),
                'status' => $schedule->status,
            ];
        })->filter(); // Remove null values (weekends)

        return response()->json([
            'success' => true,
            'data' => $formattedSchedules,
            'meta' => [
                'tanggal' => $tanggal,
                'per_minggu' => $perMinggu,
                'date_start' => $dateStart->format('Y-m-d'),
                'date_end' => $dateEnd->format('Y-m-d'),
                'room_id' => $roomId,
            ]
        ]);
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
    public function show(JadwalKelas $jadwalKelas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JadwalKelas $jadwalKelas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JadwalKelas $jadwalKelas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JadwalKelas $jadwalKelas)
    {
        //
    }
}
