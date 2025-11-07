<?php

// use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/login', fn () => view('auth.login'))->name('login');

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

Route::get('/user/dashboard', function () {
    return view('dashboard.user');
})->name('user.dashboard')->middleware('auth');

Route::get('/guest/dashboard', function () {
    return view('dashboard.guest');
})->name('guest.dashboard')->middleware('auth');
