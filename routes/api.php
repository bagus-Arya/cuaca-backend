<?php

use App\Http\Controllers\API\DeviceController;
use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Device logs routes
    Route::get('device/history', [DeviceController::class, 'getAllHistory']);
    Route::get('device/{id}/history', [DeviceController::class, 'getHistoryByMachineId']);
    Route::get('device/predict', [DeviceController::class, 'predictOneWeek']);
    Route::get('device/weather/evaluate', [DeviceController::class, 'evaluateWeatherConditions']);
    Route::get('device/weather/rainy', [DeviceController::class, 'showRainyConditions']);
    Route::post('device/logs', [DeviceController::class, 'createLogs']);
});