<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ZoneController;
use App\Http\Controllers\API\ScheduleController;
use App\Http\Controllers\API\WateringEventController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    // Zone routes
    Route::apiResource('zones', ZoneController::class);

    // Schedule routes
    Route::get('zones/{zone}/schedules', [ScheduleController::class, 'index']);
    Route::post('zones/{zone}/schedules', [ScheduleController::class, 'store']);
    Route::get('zones/{zone}/schedules/{schedule}', [ScheduleController::class, 'show']);
    Route::put('zones/{zone}/schedules/{schedule}', [ScheduleController::class, 'update']);
    Route::delete('zones/{zone}/schedules/{schedule}', [ScheduleController::class, 'destroy']);

    // Watering event routes
    Route::post('zones/{zone}/watering/start', [WateringEventController::class, 'startWatering']);
    Route::post('zones/{zone}/watering/stop', [WateringEventController::class, 'stopWatering']);
    Route::get('zones/{zone}/watering/status', [WateringEventController::class, 'getStatus']);
});

// Authentication routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');