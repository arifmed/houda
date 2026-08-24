<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\AppointmentController;

Route::prefix('auth')->group(function () {

    Route::post('/login', [
        AuthController::class,
        'login'
    ]);

});

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('auth')->group(function () {

        Route::get('/me', [
            AuthController::class,
            'me'
        ]);

        Route::post('/logout', [
            AuthController::class,
            'logout'
        ]);

    });

    Route::apiResource(
        'patients',
        PatientController::class
    );

    Route::apiResource(
        'appointments',
        AppointmentController::class
    );

});