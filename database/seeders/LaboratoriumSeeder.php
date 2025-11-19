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
                'description' => 'Laboratorium Komputer untuk mahasiswa Informatika',
                'capacity' => 30,
                'status' => 'available',
            ],
            [
                'room_name' => 'Lab Komputer 2',
                'description' => 'Laboratorium Komputer untuk mahasiswa Informatika',
                'capacity' => 30,
                'status' => 'available',
            ],
            [
                'room_name' => 'Lab Komputer 3',
                'description' => 'Laboratorium Komputer untuk mahasiswa Informatika',
                'capacity' => 30,
                'status' => 'available',
            ],
        ];

        foreach ($labs as $lab) {
            Laboratorium::firstOrCreate(
                ['room_name' => $lab['room_name']],
                $lab
            );
        }
    }
}
