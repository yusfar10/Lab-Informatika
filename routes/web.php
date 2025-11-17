<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// LOGIN
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    

// DASHBOARD CONTOH
Route::get('/admin/dashboard', function () {
    return view('dashboard.admin');
})->name('admin.dashboard')->middleware('auth');

Route::get('/admin/ruang', function () {
    return view('dashboard.admin.ruangAdmin.ruangadmin');
})->name('admin.ruang')->middleware('auth');

Route::get('/admin/user', function () {
    return view('dashboard.admin.user admin.user_admin');
})->name('admin.user')->middleware('auth');

Route::get('/user/dashboard', function () {
    return view('dashboard.user.user');
})->name('user.dashboard')->middleware('auth');

Route::get('/mahasiswa/dashboard', function () {
    return view('dashboard.mahasiswa');
})->name('mahasiswa.dashboard')->middleware('auth');

Route::get('/mahasiswa/riwayat', function () {
    return view('dashboard.mahasiswa.riwayat booking.riwayat');
})->name('mahasiswa.riwayat')->middleware('auth');

Route::get('/guest/dashboard', function () {
    return view('dashboard.guest.guest');
})->name('guest.dashboard')->middleware('auth');

