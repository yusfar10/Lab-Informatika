<?php

namespace App\Http\Controllers;

use App\Models\Laboratorium;
use App\Models\JadwalKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class LaboratoriumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $laboratoriums = Laboratorium::all();

        return response()->json([
            'success' => true,
            'data' => $laboratoriums,
            'message' => 'Data laboratorium berhasil diambil'
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
        $validator = Validator::make($request->all(), [
            'room_name' => 'required|string|max:100',
            'is_available' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $laboratorium = Laboratorium::create([
            'room_name' => $request->room_name,
            'is_available' => $request->is_available ?? true
        ]);

        return response()->json([
            'success' => true,
            'data' => $laboratorium,
            'message' => 'Laboratorium berhasil ditambahkan'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Laboratorium $laboratorium)
    {
        return response()->json([
            'success' => true,
            'data' => $laboratorium,
            'message' => 'Data laboratorium berhasil diambil'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Laboratorium $laboratorium)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Laboratorium $laboratorium)
    {
        $validator = Validator::make($request->all(), [
            'room_name' => 'string|max:100',
            'is_available' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $laboratorium->update($request->only(['room_name', 'is_available']));

        return response()->json([
            'success' => true,
            'data' => $laboratorium->fresh(),
            'message' => 'Laboratorium berhasil diperbarui'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Laboratorium $laboratorium)
    {
        $laboratorium->delete();

        return response()->json([
            'success' => true,
            'message' => 'Laboratorium berhasil dihapus'
        ]);
    }

    /**
     * Get available laboratories based on date and time
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function available(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required|date_format:H:i',
            'sks' => 'required|integer|min:1|max:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $tanggal = $request->input('tanggal');
        $jamMulai = $request->input('jam_mulai');
        $sks = $request->input('sks', 1);

        // Calculate end time (1 SKS = 50 menit)
        $durasiMenit = $sks * 50;
        $startDateTime = Carbon::parse("{$tanggal} {$jamMulai}");
        $endDateTime = $startDateTime->copy()->addMinutes($durasiMenit);

        // Get all laboratories that are available
        $allLabs = Laboratorium::where('is_available', true)->get();

        // Filter labs that don't have conflicting schedules
        $availableLabs = $allLabs->filter(function ($lab) use ($startDateTime, $endDateTime) {
            // Check if there's any conflicting schedule
            // Conflict occurs when:
            // - Existing schedule overlaps with our requested time
            // - Only check schedules with status 'schedule' (active)
            $hasConflict = JadwalKelas::where('room_id', $lab->room_id)
                ->where('status', 'schedule') // Only check active schedules
                ->where(function ($query) use ($startDateTime, $endDateTime) {
                    // Time overlap check:
                    // Existing schedule overlaps if:
                    // - Existing start_time < our end_time AND
                    // - Existing end_time > our start_time
                    $query->where('start_time', '<', $endDateTime)
                          ->where('end_time', '>', $startDateTime);
                })
                ->exists();

            return !$hasConflict;
        });

        return response()->json([
            'success' => true,
            'data' => $availableLabs->values()->map(function ($lab) {
                return [
                    'room_id' => $lab->room_id,
                    'room_name' => $lab->room_name,
                    'is_available' => $lab->is_available,
                ];
            }),
            'message' => 'Data laboratorium tersedia berhasil diambil',
            'meta' => [
                'tanggal' => $tanggal,
                'jam_mulai' => $jamMulai,
                'jam_selesai' => $endDateTime->format('H:i'),
                'sks' => $sks,
                'durasi_menit' => $durasiMenit,
            ]
        ]);
    }
}
