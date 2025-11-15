<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\api\User\RegisterController;
use App\Http\Controllers\api\User\LoginController;
use App\Http\Controllers\api\User\LogoutController;
use App\Http\Controllers\JadwalKelasController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ChangeRequestController;
use App\Http\Controllers\LaboratoriumController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\LogActivityController;
use Illuminate\Http\Request;

// Route Register User
Route::prefix('user')->group(function () {
    Route::post('/register', RegisterController::class)->name('user.register');
    Route::post('/login', LoginController::class)->name('user.login');
    Route::post('/logout', LogoutController::class)->name('user.logout');
});


Route::prefix('v1')->group(function () {
    Route::apiResources([
        'user'           => UserController::class,
        'jadwal'         => JadwalKelasController::class,
        'booking'        => BookingsController::class,
        'notification'   => NotificationController::class,
        'change-request' => ChangeRequestController::class,
        'lab'            => LaboratoriumController::class,
        'session'        => SessionController::class,
        'log'            => LogActivityController::class,
    ]);
});
