<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JadwalKelas;
use App\Models\Laboratorium;
use App\Models\User;
use Carbon\Carbon;

class JadwalKelasSeeder extends Seeder
{
    public function run(): void
    {
        $labs = Laboratorium::all();
        $dosen = User::where('role', 'dosen')->first();
        $admin = User::where('role', 'admin')->first();
        $updateBy = $admin ? $admin->id : null;

        if ($labs->isEmpty()) {
            $this->command->warn('⚠️  Laboratorium masih kosong! Jalankan LaboratoriumSeeder terlebih dahulu.');
            return;
        }

        $jadwals = [];
        $now = Carbon::now();
        $dosenNames = ['Pak Saluki', 'Bu Rina', 'Pak Budi', 'Bu Sari', 'Pak Andi', 'Bu Dewi'];
        $classNames = [
            'Pembelajaran MK Pak Saluki',
            'Pembelajaran MK Bu Rina',
            'Pembelajaran MK Pak Budi',
            'Pembelajaran MK Bu Sari',
            'Izin mau pakai buat MK Alpro 2 ya kk',
            'Pembelajaran MK Pak Andi',
            'Pembelajaran MK Bu Dewi',
        ];

        // ============================================
        // JADWAL KELAS KHUSUS UNTUK LATEST BOOKING
        // (Dengan waktu yang spesifik seperti di hardcode)
        // ============================================
        // Jadwal 1: 09.00 - 10.00 (untuk latest booking)
        $jadwals[] = [
            'class_name' => $classNames[array_rand($classNames)],
            'room_id' => $labs->random()->room_id,
            'penanggung_jawab' => $dosenNames[array_rand($dosenNames)],
            'start_time' => $now->copy()->setTime(9, 0, 0),
            'end_time' => $now->copy()->setTime(10, 0, 0),
            'status' => 'schedule',
            'update_by' => $updateBy,
            'created_at' => $now->copy()->subDays(rand(1, 5)),
            'updated_at' => $now->copy()->subDays(rand(1, 5)),
        ];
        
        // Jadwal 2: 10.00 - 11.00 (untuk latest booking)
        $jadwals[] = [
            'class_name' => $classNames[array_rand($classNames)],
            'room_id' => $labs->random()->room_id,
            'penanggung_jawab' => $dosenNames[array_rand($dosenNames)],
            'start_time' => $now->copy()->setTime(10, 0, 0),
            'end_time' => $now->copy()->setTime(11, 0, 0),
            'status' => 'schedule',
            'update_by' => $updateBy,
            'created_at' => $now->copy()->subDays(rand(1, 5)),
            'updated_at' => $now->copy()->subDays(rand(1, 5)),
        ];
        
        // Jadwal 3: 13.00 - 15.30 (untuk latest booking)
        $jadwals[] = [
            'class_name' => $classNames[array_rand($classNames)],
            'room_id' => $labs->random()->room_id,
            'penanggung_jawab' => $dosenNames[array_rand($dosenNames)],
            'start_time' => $now->copy()->setTime(13, 0, 0),
            'end_time' => $now->copy()->setTime(15, 30, 0),
            'status' => 'schedule',
            'update_by' => $updateBy,
            'created_at' => $now->copy()->subDays(rand(1, 5)),
            'updated_at' => $now->copy()->subDays(rand(1, 5)),
        ];
        
        // Jadwal 4: 08.00 - 09.30 (untuk latest booking)
        $jadwals[] = [
            'class_name' => $classNames[array_rand($classNames)],
            'room_id' => $labs->random()->room_id,
            'penanggung_jawab' => $dosenNames[array_rand($dosenNames)],
            'start_time' => $now->copy()->setTime(8, 0, 0),
            'end_time' => $now->copy()->setTime(9, 30, 0),
            'status' => 'schedule',
            'update_by' => $updateBy,
            'created_at' => $now->copy()->subDays(rand(1, 5)),
            'updated_at' => $now->copy()->subDays(rand(1, 5)),
        ];
        
        // Jadwal 5: 14.00 - 16.00 (untuk latest booking)
        $jadwals[] = [
            'class_name' => $classNames[array_rand($classNames)],
            'room_id' => $labs->random()->room_id,
            'penanggung_jawab' => $dosenNames[array_rand($dosenNames)],
            'start_time' => $now->copy()->setTime(14, 0, 0),
            'end_time' => $now->copy()->setTime(16, 0, 0),
            'status' => 'schedule',
            'update_by' => $updateBy,
            'created_at' => $now->copy()->subDays(rand(1, 5)),
            'updated_at' => $now->copy()->subDays(rand(1, 5)),
        ];

        // ============================================
        // JADWAL KELAS BULAN INI (Random)
        // ============================================
        for ($i = 0; $i < 10; $i++) {
            $startDate = $now->copy()->addDays(rand(0, 20))->setTime(rand(7, 16), rand(0, 1) * 30, 0);
            $endDate = $startDate->copy()->addHours(rand(1, 3));
            
            $jadwals[] = [
                'class_name' => $classNames[array_rand($classNames)],
                'room_id' => $labs->random()->room_id,
                'penanggung_jawab' => $dosenNames[array_rand($dosenNames)],
                'start_time' => $startDate,
                'end_time' => $endDate,
                'status' => 'schedule',
                'update_by' => $updateBy,
                'created_at' => $now->copy()->subDays(rand(1, 10)),
                'updated_at' => $now->copy()->subDays(rand(1, 10)),
            ];
        }

        // ============================================
        // JADWAL KELAS BULAN LALU
        // ============================================
        for ($i = 0; $i < 20; $i++) {
            $lastMonth = $now->copy()->subMonth();
            $startDate = $lastMonth->copy()->addDays(rand(0, 28))->setTime(rand(7, 16), rand(0, 1) * 30, 0);
            $endDate = $startDate->copy()->addHours(rand(1, 3));
            
            $jadwals[] = [
                'class_name' => 'Pembelajaran MK ' . $dosenNames[array_rand($dosenNames)],
                'room_id' => $labs->random()->room_id,
                'penanggung_jawab' => $dosenNames[array_rand($dosenNames)],
                'start_time' => $startDate,
                'end_time' => $endDate,
                'status' => rand(0, 10) > 7 ? 'completed' : 'schedule', // 30% completed
                'update_by' => $updateBy,
                'created_at' => $lastMonth->copy()->subDays(rand(1, 10)),
                'updated_at' => $lastMonth->copy()->subDays(rand(1, 10)),
            ];
        }

        // ============================================
        // JADWAL KELAS 2-3 BULAN LALU
        // ============================================
        for ($i = 0; $i < 25; $i++) {
            $monthsAgo = $now->copy()->subMonths(rand(2, 3));
            $startDate = $monthsAgo->copy()->addDays(rand(0, 28))->setTime(rand(7, 16), rand(0, 1) * 30, 0);
            $endDate = $startDate->copy()->addHours(rand(1, 3));
            
            $jadwals[] = [
                'class_name' => 'Pembelajaran MK ' . $dosenNames[array_rand($dosenNames)],
                'room_id' => $labs->random()->room_id,
                'penanggung_jawab' => $dosenNames[array_rand($dosenNames)],
                'start_time' => $startDate,
                'end_time' => $endDate,
                'status' => rand(0, 10) > 5 ? 'completed' : 'schedule', // 50% completed
                'update_by' => $updateBy,
                'created_at' => $monthsAgo->copy()->subDays(rand(1, 10)),
                'updated_at' => $monthsAgo->copy()->subDays(rand(1, 10)),
            ];
        }

        // Insert semua jadwal
        foreach ($jadwals as $jadwal) {
            JadwalKelas::create($jadwal);
        }

        $this->command->info('✅ JadwalKelasSeeder: ' . count($jadwals) . ' jadwal kelas berhasil dibuat!');
    }
}

