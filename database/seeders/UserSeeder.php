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
                'role' => 'mahasiswa',
                'semester' => 5,
                'kelas' => 'Mahasiswa',
                'no_hp' => '81234567000',
            ],
            [
                'email' => 'Kosma_it1A@gmail.com',
                'name' => 'Kosma Informatika 1A',
                'username' => 'Kosma_it1A',
                'password' => Hash::make('Kosma1A123'),
                'role' => 'mahasiswa', //
                'semester' => 1,
                'kelas' => 'Kelas Informatika 1 A',
                'no_hp' => '81234567001',
            ],
            [
                'name' => 'Kosma Informatika 1B',
                'username' => 'Kosma_it1B',
                'email' => 'Kosma_it1B@gmail.com',
                'password' => Hash::make('Kosma1B123'),
                'role' => 'mahasiswa',
                'semester' => 1,
                'kelas' => 'Kelas Informatika 1 B',
                'no_hp' => '81234567002',
            ],
            [
                'name' => 'Kosma Informatika 1C',
                'username' => 'Kosma_it1C',
                'email' => 'Kosma_it1C@gmail.com',
                'password' => Hash::make('Kosma1C123'),
                'role' => 'mahasiswa',
                'semester' => 1,
                'kelas' => 'Kelas Informatika 1 C',
                'no_hp' => '81234567003',
            ],
            [
                'name' => 'Kosma Informatika 1D',
                'username' => 'Kosma_it1D',
                'email' => 'Kosma_it1D@gmail.com',
                'password' => Hash::make('Kosma1D123'),
                'role' => 'mahasiswa',
                'semester' => 1,
                'kelas' => 'Kelas Informatika 1 D',
                'no_hp' => '81234567004',
            ],
            [
                'name' => 'Kosma Informatika 2A',
                'username' => 'Kosma_it2A',
                'email' => 'Kosma_it2A@gmail.com',
                'password' => Hash::make('Kosma2A123'),
                'role' => 'mahasiswa',
                'semester' => 3,
                'kelas' => 'Kelas Informatika 2 A',
                'no_hp' => '81234567005',
            ],
            [
                'name' => 'Kosma Informatika 2B',
                'username' => 'Kosma_it2B',
                'email' => 'Kosma_it2B@gmail.com',
                'password' => Hash::make('Kosma2B123'),
                'role' => 'mahasiswa',
                'semester' => 3,
                'kelas' => 'Kelas Informatika 2 B',
                'no_hp' => '81234567006',
            ],
            [
                'name' => 'Kosma Informatika 2C',
                'username' => 'Kosma_it2C',
                'email' => 'Kosma_it2C@gmail.com',
                'password' => Hash::make('Kosma2C123'),
                'role' => 'mahasiswa',
                'semester' => 3,
                'kelas' => 'Kelas Informatika 2 C',
                'no_hp' => '81234567007',
            ],
            [
                'name' => 'Yusuf Alim Romadon Kecee',
                'username' => 'Kosma_it5A',
                'email' => 'Kosma_it5A@gmail.com',
                'password' => Hash::make('Kosma5A123'),
                'role' => 'mahasiswa',
                'semester' => 5,
                'kelas' => 'Kelas Informatika 5 A',
                'no_hp' => '81234567008',
            ],
            [
                'name' => 'Kosma Informatika 5B',
                'username' => 'Kosma_it5B',
                'email' => 'Kosma_it5B@gmail.com',
                'password' => Hash::make('Kosma5B123'),
                'role' => 'mahasiswa',
                'semester' => 5,
                'kelas' => 'Kelas Informatika 5 B',
                'no_hp' => '81234567009',
            ],
            [
                'name' => 'ADMIN LAB 1',
                'username' => 'ADMIN_1',
                'email' => 'admin1@gmail.com',
                'password' => Hash::make('AdminLab1'),
                'role' => 'admin',
            ],
            [
                'name' => 'ADMIN LAB 2',
                'username' => 'ADMIN_2',
                'email' => 'admin2@gmail.com',
                'password' => Hash::make('AdminLab1'),
                'role' => 'admin',
            ],
            [
                'name' => 'rizky',
                'username' => 'rizky',
                'email' => 'muhammadarf5555@gmail.com',
                'password' => Hash::make('Arifrizky123456'),
                'role' => 'mahasiswa',
                'semester' => 5,
                'kelas' => 'Kelas Informatika 5 A',
                'no_hp' => '085172033209',
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
