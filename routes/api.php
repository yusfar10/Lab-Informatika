<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JadwalKelasController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ChangeRequestController;
use App\Http\Controllers\LaboratoriumController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\LogActivityController;

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
