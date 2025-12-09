<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bookings;
use App\Models\JadwalKelas;
use App\Models\User;
use Carbon\Carbon;

class BookingsSeeder extends Seeder
{
    public function run(): void
    {
        $jadwals = JadwalKelas::with('laboratorium')->get();
        // Pastikan hanya ambil user yang memiliki kelas (tidak null)
        $users = User::where('role', 'mahasiswa')
            ->whereNotNull('kelas')
            ->where('kelas', '!=', '')
            ->get();

        if ($jadwals->isEmpty() || $users->isEmpty()) {
            $this->command->warn('⚠️  JadwalKelas atau User masih kosong! Jalankan seeder JadwalKelas dan User terlebih dahulu.');
            return;
        }
        
        // Pastikan ada jadwal yang memiliki laboratorium
        $jadwals = $jadwals->filter(function ($jadwal) {
            return $jadwal->laboratorium !== null;
        });
        
        if ($jadwals->isEmpty()) {
            $this->command->warn('⚠️  Tidak ada jadwal kelas yang memiliki laboratorium!');
            return;
        }

        // Clear existing bookings untuk fresh data (opsional, bisa di-comment jika tidak ingin clear)
        // Bookings::truncate();

        $bookings = [];
        $now = Carbon::now();
        
        // ============================================
        // LATEST BOOKINGS (5 bookings terbaru untuk ditampilkan)
        // Menggunakan jadwal kelas dengan waktu spesifik (5 jadwal pertama)
        // Pastikan menggunakan user yang memiliki kelas lengkap
        // ============================================
        // Ambil 5 jadwal pertama (yang memiliki waktu spesifik dan laboratorium)
        $latestJadwals = $jadwals->take(5);
        
        // Pastikan ada user yang memiliki kelas
        if ($users->isEmpty()) {
            $this->command->warn('⚠️  Tidak ada user dengan kelas! Pastikan UserSeeder sudah dijalankan.');
            return;
        }
        
        // Pastikan user memiliki semua field yang diperlukan
        $validUsers = $users->filter(function ($user) {
            return !empty($user->name) && 
                   !empty($user->username) && 
                   !empty($user->kelas);
        });
        
        if ($validUsers->isEmpty()) {
            $this->command->warn('⚠️  Tidak ada user dengan data lengkap!');
            return;
        }
        
        if ($latestJadwals->count() >= 5) {
            // Booking 1: 5 menit yang lalu
            $bookings[] = [
                'user_id' => $validUsers->random()->id,
                'class_id' => $latestJadwals[0]->class_id,
                'booking_time' => $now->copy()->subMinutes(5),
                'created_at' => $now->copy()->subMinutes(5),
                'updated_at' => $now->copy()->subMinutes(5),
            ];
            
            // Booking 2: 37 menit yang lalu
            $bookings[] = [
                'user_id' => $validUsers->random()->id,
                'class_id' => $latestJadwals[1]->class_id,
                'booking_time' => $now->copy()->subMinutes(37),
                'created_at' => $now->copy()->subMinutes(37),
                'updated_at' => $now->copy()->subMinutes(37),
            ];
            
            // Booking 3: 2 jam yang lalu
            $bookings[] = [
                'user_id' => $validUsers->random()->id,
                'class_id' => $latestJadwals[2]->class_id,
                'booking_time' => $now->copy()->subHours(2),
                'created_at' => $now->copy()->subHours(2),
                'updated_at' => $now->copy()->subHours(2),
            ];
            
            // Booking 4: 5 jam yang lalu
            $bookings[] = [
                'user_id' => $validUsers->random()->id,
                'class_id' => $latestJadwals[3]->class_id,
                'booking_time' => $now->copy()->subHours(5),
                'created_at' => $now->copy()->subHours(5),
                'updated_at' => $now->copy()->subHours(5),
            ];
            
            // Booking 5: 1 hari yang lalu
            $bookings[] = [
                'user_id' => $validUsers->random()->id,
                'class_id' => $latestJadwals[4]->class_id,
                'booking_time' => $now->copy()->subDay(),
                'created_at' => $now->copy()->subDay(),
                'updated_at' => $now->copy()->subDay(),
            ];
        } else {
            // Fallback jika jadwal kurang dari 5
            for ($i = 0; $i < min(5, $latestJadwals->count()); $i++) {
                $minutesAgo = [5, 37, 120, 300, 1440]; // 5 menit, 37 menit, 2 jam, 5 jam, 1 hari
                $bookings[] = [
                    'user_id' => $validUsers->random()->id,
                    'class_id' => $latestJadwals[$i]->class_id,
                    'booking_time' => $now->copy()->subMinutes($minutesAgo[$i]),
                    'created_at' => $now->copy()->subMinutes($minutesAgo[$i]),
                    'updated_at' => $now->copy()->subMinutes($minutesAgo[$i]),
                ];
            }
        }
        
        // ============================================
        // BOOKINGS BULAN INI (15-20 bookings lainnya)
        // ============================================
        for ($i = 0; $i < 15; $i++) {
            $bookings[] = [
                'user_id' => $validUsers->random()->id,
                'class_id' => $jadwals->random()->class_id,
                'booking_time' => $now->copy()->subDays(rand(1, $now->day))->subHours(rand(0, 23))->subMinutes(rand(0, 59)),
                'created_at' => $now->copy()->subDays(rand(1, $now->day))->subHours(rand(0, 23)),
                'updated_at' => $now->copy()->subDays(rand(1, $now->day))->subHours(rand(0, 23)),
            ];
        }

        // ============================================
        // BOOKINGS BULAN LALU (30-40 bookings)
        // ============================================
        for ($i = 0; $i < 35; $i++) {
            $lastMonth = $now->copy()->subMonth();
            $bookings[] = [
                'user_id' => $validUsers->random()->id,
                'class_id' => $jadwals->random()->class_id,
                'booking_time' => $lastMonth->copy()->subDays(rand(0, 28))->subHours(rand(0, 23))->subMinutes(rand(0, 59)),
                'created_at' => $lastMonth->copy()->subDays(rand(0, 28))->subHours(rand(0, 23)),
                'updated_at' => $lastMonth->copy()->subDays(rand(0, 28))->subHours(rand(0, 23)),
            ];
        }

        // ============================================
        // BOOKINGS 2-3 BULAN LALU (40-50 bookings)
        // ============================================
        for ($i = 0; $i < 45; $i++) {
            $monthsAgo = $now->copy()->subMonths(rand(2, 3));
            $bookings[] = [
                'user_id' => $validUsers->random()->id,
                'class_id' => $jadwals->random()->class_id,
                'booking_time' => $monthsAgo->copy()->subDays(rand(0, 28))->subHours(rand(0, 23))->subMinutes(rand(0, 59)),
                'created_at' => $monthsAgo->copy()->subDays(rand(0, 28))->subHours(rand(0, 23)),
                'updated_at' => $monthsAgo->copy()->subDays(rand(0, 28))->subHours(rand(0, 23)),
            ];
        }

        // ============================================
        // BOOKINGS LAMA (20-30 bookings)
        // ============================================
        for ($i = 0; $i < 25; $i++) {
            $oldDate = $now->copy()->subMonths(rand(4, 6));
            $bookings[] = [
                'user_id' => $validUsers->random()->id,
                'class_id' => $jadwals->random()->class_id,
                'booking_time' => $oldDate->copy()->subDays(rand(0, 28))->subHours(rand(0, 23))->subMinutes(rand(0, 59)),
                'created_at' => $oldDate->copy()->subDays(rand(0, 28))->subHours(rand(0, 23)),
                'updated_at' => $oldDate->copy()->subDays(rand(0, 28))->subHours(rand(0, 23)),
            ];
        }

        // Insert semua bookings
        foreach ($bookings as $booking) {
            Bookings::firstOrCreate(
                [
                    'user_id' => $booking['user_id'],
                    'class_id' => $booking['class_id'],
                    'booking_time' => $booking['booking_time']
                ],
                $booking
            );
        }

        $this->command->info('✅ BookingsSeeder: ' . count($bookings) . ' bookings berhasil dibuat!');
        $this->command->info('   - Latest bookings (untuk ditampilkan): 5');
        $this->command->info('   - Bookings bulan ini: ~20');
        $this->command->info('   - Total bookings: ~' . count($bookings));
    }
}
