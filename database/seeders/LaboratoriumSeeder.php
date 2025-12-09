<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Laboratorium;

class LaboratoriumSeeder extends Seeder
{
    public function run(): void
    {
        $labs = [
            [
                'room_name' => 'Lab Komputer 1',
                'is_available' => true,
            ],
            [
                'room_name' => 'Lab Komputer 2',
                'is_available' => true,
            ],
        ];

        foreach ($labs as $lab) {
            Laboratorium::firstOrCreate(
                ['room_name' => $lab['room_name']],
                $lab
            );
        }

        $this->command->info('✅ LaboratoriumSeeder: ' . count($labs) . ' laboratorium berhasil dibuat!');
    }
}
