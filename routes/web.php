<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\DashboardController;

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

// Route::get('/user/dashboard', function () {
//     return view('dashboard.user.user');
// })->name('user.dashboard')->middleware('auth');

// NAV
Route::get('/mahasiswa/dashboard', function () {
    return view('dashboard.mahasiswa');
})->name('mahasiswa.dashboard')->middleware('auth');

// Dashboard API Routes (Web - menggunakan session auth)
Route::middleware('auth')->group(function () {
    Route::get('/api/dashboard/stats', [DashboardController::class, 'stats'])->name('dashboard.stats.web');
    Route::get('/api/bookings/latest', [App\Http\Controllers\BookingsController::class, 'latest'])->name('bookings.latest.web');
    Route::get('/api/booking/info', [App\Http\Controllers\BookingsController::class, 'info'])->name('booking.info.web');
    Route::post('/api/booking', [App\Http\Controllers\BookingsController::class, 'store'])->name('booking.store.web');
    Route::get('/api/lab', [App\Http\Controllers\LaboratoriumController::class, 'index'])->name('lab.index.web');
    Route::get('/api/lab/available', [App\Http\Controllers\LaboratoriumController::class, 'available'])->name('lab.available.web');
    Route::get('/api/jadwal', [App\Http\Controllers\JadwalKelasController::class, 'index'])->name('jadwal.index.web');
});

Route::get('/mahasiswa/riwayat', function () {
    return view('dashboard.mahasiswa.riwayat booking.riwayat');
})->name('mahasiswa.riwayat')->middleware('auth');

Route::get('/mahasiswa/booking-kelas', function () {
    return view('dashboard.mahasiswa.booking class.booking');
})->name('mahasiswa.booking-kelas')->middleware('auth');

Route::get('/mahasiswa/jadwal-kuliah', function () {
    return view('dashboard.mahasiswa.jadwal-kuliah.jadwal');
})->name('mahasiswa.jadwal-kuliah')->middleware('auth');

Route::get('/guest/dashboard', function () {
    return view('dashboard.guest.guest');
})->name('guest.dashboard')->middleware('auth');

// Detail
Route::get('/mahasiswa/datail', function () {
    return view('dashboard.mahasiswa.detail.detail');
})->name('mahasiswa.detail')->middleware('auth');

// PASSWORD RESET ROUTES
Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');


// error Handling
Route::get('/test500', function () {
    abort(500); // Fatal error
});

Route::get('/test403', function () {
    abort(403);
});

