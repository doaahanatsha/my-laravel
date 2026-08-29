<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\WorkLocationController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\VolunteerController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/me', [VolunteerController::class, 'me']);
    Route::put('/me', [VolunteerController::class, 'updateMe']);

    // Any authenticated user (Admin + Volunteer)
    Route::apiResource('work-locations', WorkLocationController::class)
        ->only(['index', 'show']);

    Route::apiResource('tasks', TaskController::class)
        ->only(['index', 'show']);

    // Admin only
    Route::middleware('admin')->group(function () {

        Route::apiResource('work-locations', WorkLocationController::class)
            ->except(['index', 'show']);

        Route::apiResource('tasks', TaskController::class)
            ->except(['index', 'show']);

        Route::apiResource('volunteers', VolunteerController::class);
    });

});