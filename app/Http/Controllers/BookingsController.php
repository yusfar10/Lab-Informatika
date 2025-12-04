<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\JadwalKelas;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class BookingsController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }
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
        try {
            $validator = Validator::make($request->all(), [
                'penggunaan_kelas' => 'required|string|max:100',
                'room_id' => 'required|exists:laboratorium,room_id',
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

            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak terautentikasi'
                ], 401);
            }

            $tanggal = $request->input('tanggal');
            $jamMulai = $request->input('jam_mulai');
            $sks = $request->input('sks');
            $roomId = $request->input('room_id');
            $penggunaanKelas = $request->input('penggunaan_kelas');

            // Calculate end time (1 SKS = 50 menit)
            $durasiMenit = $sks * 50;
            $startDateTime = Carbon::parse("{$tanggal} {$jamMulai}");
            $endDateTime = $startDateTime->copy()->addMinutes($durasiMenit);

            // Validasi: Tanggal booking tidak boleh di masa lalu
            $today = Carbon::today();
            $selectedDate = Carbon::parse($tanggal)->startOfDay();
            if ($selectedDate->isPast() && !$selectedDate->isToday()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat memilih tanggal yang sudah lampau. Silakan pilih tanggal hari ini atau yang akan datang.'
                ], 422);
            }

            // Validasi: Jam booking harus dalam jam kerja (07:00 - 17:30)
            $jamMulaiCarbon = Carbon::parse($jamMulai);
            $jamKerjaMulai = Carbon::parse('07:00');
            $jamKerjaAkhir = Carbon::parse('17:30');
            
            if ($jamMulaiCarbon->lt($jamKerjaMulai) || $jamMulaiCarbon->gt($jamKerjaAkhir)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jam booking harus dalam jam kerja (07:00 - 17:30).'
                ], 422);
            }

            // Validasi: Jika tanggal hari ini, jam tidak boleh di masa lalu
            if ($selectedDate->isToday()) {
                $now = Carbon::now();
                if ($startDateTime->isPast()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Tidak dapat memilih waktu yang sudah lampau. Silakan pilih waktu yang akan datang.'
                    ], 422);
                }
            }
            
            // Validasi: Waktu selesai tidak boleh melewati jam kerja (17:30)
            if ($endDateTime->format('H:i') > '17:30') {
                return response()->json([
                    'success' => false,
                    'message' => 'Waktu selesai booking tidak boleh melewati jam kerja (17:30).'
                ], 422);
            }

            // Check for conflicts
            $hasConflict = JadwalKelas::where('room_id', $roomId)
                ->where('status', 'schedule')
                ->where(function ($query) use ($startDateTime, $endDateTime) {
                    $query->where('start_time', '<', $endDateTime)
                          ->where('end_time', '>', $startDateTime);
                })
                ->exists();

            if ($hasConflict) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jadwal bertabrakan dengan jadwal yang sudah ada'
                ], 409);
            }

            // Get user's kelas for penanggung_jawab
            $penanggungJawab = $user->name . ($user->kelas ? ' - ' . $user->kelas : '');

            // Create JadwalKelas
            $jadwalKelas = JadwalKelas::create([
                'class_name' => $penggunaanKelas,
                'room_id' => $roomId,
                'penanggung_jawab' => $penanggungJawab,
                'start_time' => $startDateTime,
                'end_time' => $endDateTime,
                'status' => 'schedule',
                'update_by' => $user->id,
            ]);

            // Create Booking
            $booking = Bookings::create([
                'user_id' => $user->id,
                'class_id' => $jadwalKelas->class_id,
                'booking_time' => $startDateTime,
            ]);

            // Load relationships yang diperlukan untuk NotificationService
            $booking->load(['user', 'jadwalKelas.laboratorium']);

            // Hapus debug logging untuk performa lebih baik
            // \Log::info('Attempting to create notification', [...]);

            // Create notification dengan SKS (optimasi: kurangi logging)
            try {
                $this->notificationService->notifyBookingCreated($booking, $sks);
                // Tidak log success untuk performa lebih baik, hanya log error
            } catch (\Exception $e) {
                // Log error but don't fail the booking creation
                \Log::error('Failed to create notification for booking', [
                    'booking_id' => $booking->booking_id,
                    'user_id' => $booking->user_id,
                    'error' => $e->getMessage()
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Booking berhasil dibuat',
                'data' => [
                    'booking_id' => $booking->booking_id,
                    'jadwal_kelas' => [
                        'class_id' => $jadwalKelas->class_id,
                        'class_name' => $jadwalKelas->class_name,
                        'start_time' => $jadwalKelas->start_time,
                        'end_time' => $jadwalKelas->end_time,
                    ]
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat booking',
                'error' => $e->getMessage()
            ], 500);
        }
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
    public function latest(Request $request)
    {
        try {
            // Get filter parameters
            $tanggal = $request->input('tanggal');
            $jam = $request->input('jam');
            $roomId = $request->input('room_id');
            
            $query = Bookings::with([
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
            ->whereHas('jadwalKelas.laboratorium');
            
            // Apply filters
            if ($tanggal) {
                $query->whereHas('jadwalKelas', function ($q) use ($tanggal) {
                    $q->whereDate('start_time', $tanggal);
                });
            }
            
            // Filter jam dihapus sesuai permintaan user
            
            if ($roomId) {
                $query->whereHas('jadwalKelas', function ($q) use ($roomId) {
                    $q->where('room_id', $roomId);
                });
            }
            
            $latestBookings = $query->orderBy('created_at', 'desc')
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

            // Debug: Log jika tidak ada data
            if ($latestBookings->isEmpty()) {
                \Log::info('Latest bookings empty', [
                    'filters' => [
                        'tanggal' => $tanggal,
                        'jam' => $jam,
                        'room_id' => $roomId
                    ],
                    'total_bookings' => Bookings::count()
                ]);
            }

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

    /**
     * Get booking information by class_id
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function info(Request $request)
    {
        try {
            $classId = $request->input('class_id');
            
            if (!$classId) {
                return response()->json([
                    'success' => false,
                    'message' => 'class_id is required'
                ], 400);
            }
            
            // Get booking for this class
            $booking = Bookings::with([
                'user:id,name,username,kelas',
                'jadwalKelas:class_id,class_name,room_id,start_time,end_time,penanggung_jawab',
                'jadwalKelas.laboratorium:room_id,room_name'
            ])
            ->where('class_id', $classId)
            ->first();
            
            if (!$booking) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking not found'
                ], 404);
            }
            
            $user = $booking->user;
            $jadwalKelas = $booking->jadwalKelas;
            $laboratorium = $jadwalKelas->laboratorium;
            
            // Format time
            $startTime = \Carbon\Carbon::parse($jadwalKelas->start_time);
            $endTime = \Carbon\Carbon::parse($jadwalKelas->end_time);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'booking_id' => $booking->booking_id,
                    'booking_time' => $booking->booking_time,
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'username' => $user->username,
                        'kelas' => $user->kelas,
                    ],
                    'jadwal_kelas' => [
                        'class_id' => $jadwalKelas->class_id,
                        'class_name' => $jadwalKelas->class_name,
                        'penanggung_jawab' => $jadwalKelas->penanggung_jawab,
                        'time_start' => $startTime->format('H:i'),
                        'time_end' => $endTime->format('H:i'),
                        'laboratorium' => [
                            'room_id' => $laboratorium->room_id,
                            'room_name' => $laboratorium->room_name,
                        ],
                    ],
                ],
                'message' => 'Booking information retrieved successfully'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve booking information',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get booking history for authenticated user
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function history(Request $request)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak terautentikasi'
                ], 401);
            }

            // Get filter parameters
            $status = $request->input('status');
            
            // Query bookings for current user
            // Exclude cancelled bookings
            $query = Bookings::with([
                'user:id,name,username,kelas',
                'jadwalKelas:class_id,class_name,room_id,start_time,end_time,penanggung_jawab,status',
                'jadwalKelas.laboratorium:room_id,room_name'
            ])
            ->where('user_id', $user->id)
            ->whereHas('jadwalKelas', function ($q) {
                $q->where('status', '!=', 'cancelled');
            })
            ->orderBy('created_at', 'desc');

            // Apply status filter
            if ($status && $status !== '') {
                if ($status === 'schedule' || $status === 'aktif' || $status === 'active') {
                    // Filter untuk aktif: status schedule dan belum lewat
                    $query->whereHas('jadwalKelas', function ($q) {
                        $q->where('status', 'schedule')
                          ->where('end_time', '>', Carbon::now());
                    });
                } elseif ($status === 'completed') {
                    // Filter untuk completed: status completed ATAU sudah lewat waktunya
                    $query->whereHas('jadwalKelas', function ($q) {
                        $q->where(function ($subQ) {
                            $subQ->where('status', 'completed')
                                 ->orWhere('end_time', '<=', Carbon::now());
                        });
                    });
                }
                // Skip cancelled bookings dari filter aktif/completed
            }

            $bookings = $query->get()->map(function ($booking) {
                $user = $booking->user;
                $jadwalKelas = $booking->jadwalKelas;
                
                $result = [
                    'booking_id' => $booking->booking_id,
                    'created_at' => $booking->created_at ? $booking->created_at->toDateTimeString() : null,
                    'booking_time' => $booking->booking_time ? $booking->booking_time->toDateTimeString() : null,
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'username' => $user->username,
                        'kelas' => $user->kelas,
                    ],
                ];

                if ($jadwalKelas) {
                    $laboratorium = $jadwalKelas->laboratorium;
                    
                    // Tentukan display_status berdasarkan waktu dan status
                    $now = Carbon::now();
                    $endTime = $jadwalKelas->end_time ? Carbon::parse($jadwalKelas->end_time) : null;
                    
                    // Tentukan display_status berdasarkan waktu dan status
                    // (Cancelled sudah di-exclude di query awal)
                    if ($jadwalKelas->status === 'completed') {
                        $displayStatus = 'completed';
                    }
                    // Jika end_time sudah lewat, otomatis jadi completed
                    elseif ($endTime && $endTime->isPast()) {
                        $displayStatus = 'completed';
                    }
                    // Jika masih schedule dan belum lewat, tetap aktif
                    else {
                        $displayStatus = 'aktif';
                    }
                    
                    $result['jadwalKelas'] = [
                        'class_id' => $jadwalKelas->class_id,
                        'class_name' => $jadwalKelas->class_name,
                        'start_time' => $jadwalKelas->start_time ? $jadwalKelas->start_time->toDateTimeString() : null,
                        'end_time' => $jadwalKelas->end_time ? $jadwalKelas->end_time->toDateTimeString() : null,
                        'status' => $jadwalKelas->status,
                    ];
                    
                    // Tambahkan display_status untuk frontend
                    $result['display_status'] = $displayStatus;

                    if ($laboratorium) {
                        $result['jadwalKelas']['laboratorium'] = [
                            'room_id' => $laboratorium->room_id,
                            'room_name' => $laboratorium->room_name,
                        ];
                    }
                }

                return $result;
            });

            return response()->json([
                'success' => true,
                'data' => $bookings,
                'message' => 'Booking history retrieved successfully'
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Failed to retrieve booking history', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil riwayat booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
