<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\api\User\RegisterController;
use App\Http\Controllers\api\User\LoginController;
use App\Http\Controllers\api\User\LogoutController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\JadwalKelasController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\ChangeRequestController;
use App\Http\Controllers\LaboratoriumController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\DashboardController;

// User Register & Login
Route::prefix('user')->group(function () {
    Route::post('/register', RegisterController::class)->name('user.register');
    Route::post('/login', LoginController::class)->name('user.login');
    Route::post('/logout', LogoutController::class)->name('user.logout');
});

// JWT Auth Routes
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/guest-login', [AuthController::class, 'guestLogin'])->name('auth.guest-login');
    Route::post('/refresh', [AuthController::class, 'refreshToken'])->name('auth.refresh');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    // Password reset API
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail']);
    Route::post('/reset-password', [PasswordResetController::class, 'reset']);
});

// Protected API routes
Route::prefix('v1')->middleware(['auth:api'])->group(function () {
    Route::apiResources([
        'user'           => UserController::class,
        'jadwal'         => JadwalKelasController::class,
        'notification'   => NotificationController::class,
        'change-request' => ChangeRequestController::class,
        'lab'            => LaboratoriumController::class,
        'session'        => SessionController::class,
        'log'            => LogActivityController::class,
    ]);

    // Booking routes with semester middleware for store method
    Route::apiResource('booking', BookingsController::class)->except(['store']);

    // Dashboard routes
    Route::get('dashboard/stats', [DashboardController::class, 'stats'])->name('dashboard.stats');

    // Bookings additional routes
    Route::get('bookings/latest', [BookingsController::class, 'latest'])->name('bookings.latest');
    Route::post('booking', [BookingsController::class, 'store'])->middleware('semester')->name('booking.store');

    // Lab additional routes 
    Route::get('lab/available', [LaboratoriumController::class, 'available'])->name('lab.available');
    
// NOTIFICATION
    Route::get('/notification', [NotificationController::class, 'index']);
    Route::put('/notification/{id}', [NotificationController::class, 'markAsRead']);
    Route::put('/notification/mark-all-read', [NotificationController::class, 'markAllRead']);
    Route::get('/notification/unread-count', [NotificationController::class, 'unreadCount']);

}); //



