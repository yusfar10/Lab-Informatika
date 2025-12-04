<?php

namespace App\Http\Controllers;

use App\Models\JadwalKelas;
use App\Models\Laboratorium;
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

        // Validasi format tanggal (YYYY-MM-DD)
        if ($tanggal && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal)) {
            return response()->json([
                'success' => false,
                'message' => 'Format tanggal tidak valid. Gunakan format YYYY-MM-DD.'
            ], 400);
        }

        try {
            $selectedDate = Carbon::createFromFormat('Y-m-d', $tanggal)->startOfDay();
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Tanggal tidak valid: ' . $tanggal
            ], 400);
        }
        
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
        $query = JadwalKelas::with('laboratorium:room_id,room_name,is_available')
            ->whereBetween('start_time', [$dateStart, $dateEnd])
            ->where('status', 'schedule'); // Only active schedules

        // Filter by room_id if provided
        if ($roomId) {
            $query->where('room_id', $roomId);
        }

        // Filter hanya_tersedia (only available labs)
        if ($hanyaTersedia) {
            $query->whereHas('laboratorium', function ($q) {
                $q->where('is_available', true);
            });
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
        // Get authenticated user
        $user = auth()->user();

        // Validasi: user hanya bisa update jadwal yang penanggung_jawab = user name/email
        if ($jadwalKelas->penanggung_jawab !== $user->name && $jadwalKelas->penanggung_jawab !== $user->email) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki izin untuk mengupdate jadwal ini'
            ], 403);
        }

        // Validasi input
        $validator = validator($request->all(), [
            'class_name' => 'sometimes|required|string|max:255',
            'room_id' => 'sometimes|required|integer|exists:laboratorium,room_id',
            'start_time' => 'sometimes|required|date',
            'end_time' => 'sometimes|required|date|after:start_time',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Jika ada perubahan waktu atau room, lakukan conflict detection
        $hasTimeOrRoomChange = $request->has('start_time') || $request->has('end_time') || $request->has('room_id');

        if ($hasTimeOrRoomChange) {
            $newStartTime = $request->input('start_time', $jadwalKelas->start_time);
            $newEndTime = $request->input('end_time', $jadwalKelas->end_time);
            $newRoomId = $request->input('room_id', $jadwalKelas->room_id);

            // Parse times
            $startDateTime = Carbon::parse($newStartTime);
            $endDateTime = Carbon::parse($newEndTime);

            // Conflict detection logic: Cek apakah lab tersedia di waktu yang diminta
            $lab = Laboratorium::find($newRoomId);
            if (!$lab || !$lab->is_available) {
                return response()->json([
                    'success' => false,
                    'message' => 'Laboratorium tidak tersedia'
                ], 422);
            }

            // Conflict detection logic: Cek apakah ada jadwal lain yang overlap
            // Exclude jadwal yang sedang di-update dari pengecekan
            $conflictingSchedule = JadwalKelas::where('room_id', $newRoomId)
                ->where('status', 'schedule')
                ->where('class_id', '!=', $jadwalKelas->class_id) // Exclude current schedule
                ->where(function ($query) use ($startDateTime, $endDateTime) {
                    // Time overlap check:
                    // Existing schedule overlaps if:
                    // - Existing start_time < our end_time AND
                    // - Existing end_time > our start_time
                    $query->where('start_time', '<', $endDateTime)
                          ->where('end_time', '>', $startDateTime);
                })
                ->with('laboratorium:room_id,room_name')
                ->first();

            // Jika konflik, return error
            if ($conflictingSchedule) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jadwal bentrok dengan jadwal lain',
                    'conflict_with' => [
                        'class_id' => $conflictingSchedule->class_id,
                        'class_name' => $conflictingSchedule->class_name,
                        'room_name' => $conflictingSchedule->laboratorium->room_name ?? 'N/A',
                        'penanggung_jawab' => $conflictingSchedule->penanggung_jawab,
                        'start_time' => $conflictingSchedule->start_time,
                        'end_time' => $conflictingSchedule->end_time,
                    ]
                ], 422);
            }
        }

        // Jika tidak konflik, update jadwal
        $updateData = $request->only(['class_name', 'room_id', 'start_time', 'end_time']);
        $updateData['update_by'] = $user->id;

        $jadwalKelas->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil diperbarui',
            'data' => $jadwalKelas->fresh()->load('laboratorium:room_id,room_name')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JadwalKelas $jadwalKelas)
    {
        //
    }
}
