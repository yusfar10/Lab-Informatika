<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create(['name'=>'admin', 'email' =>'admin@gmail.com', 'password'=>'admin']); 
        User::create(['name'=>'dosen', 'email' =>'dosen@gmail.com', 'password'=>'dosen']); 
        User::create(['name'=>'mahasiswa', 'email' =>'mahasiswa@gmail.com', 'password'=>'mahasiswa']); 
    }
}
