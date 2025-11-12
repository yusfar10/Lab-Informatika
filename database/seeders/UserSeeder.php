<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin'),
                'role' => 'admin'
            ],
            [
                'name' => 'Dosen',
                'username' => 'dosen',
                'email' => 'dosen@gmail.com',
                'password' => Hash::make('dosen'),
                'role' => 'dosen'
            ],
            [
                'name' => 'Mahasiswa',
                'username' => 'mahasiswa',
                'email' => 'mahasiswa@gmail.com',
                'password' => Hash::make('mahasiswa'),
                'role' => 'mahasiswa'
            ],
        ];

        foreach ($users as $user) {
            User::firstOrCreate(  // 👈 ini kuncinya
                ['email' => $user['email']], // cek dulu berdasarkan email
                $user // kalau belum ada → buat baru
            );
        }
    }
}
