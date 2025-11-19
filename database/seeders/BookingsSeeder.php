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
        $jadwals = JadwalKelas::all();
        $users = User::where('role', 'mahasiswa')->get();

        if ($jadwals->isEmpty() || $users->isEmpty()) {
            return;
        }

        $bookings = [];
        for ($i = 0; $i < 10; $i++) {
            $bookings[] = [
                'user_id' => $users->random()->id,
                'class_id' => $jadwals->random()->class_id,
                'booking_time' => Carbon::now()->subDays(rand(0, 30))->subHours(rand(0, 23)),
            ];
        }

        foreach ($bookings as $booking) {
            Bookings::firstOrCreate(
                ['user_id' => $booking['user_id'], 'class_id' => $booking['class_id'], 'booking_time' => $booking['booking_time']],
                $booking
            );
        }
    }
}
