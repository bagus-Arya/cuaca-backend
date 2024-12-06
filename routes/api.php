<?php

use App\Http\Controllers\API\DeviceController;
use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/device/store/Jklame)923l!@kj2k3;Lk', [DeviceController::class, 'createLogs']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Device logs routes
    Route::get('user-devices/{userId}', [DeviceController::class, 'getUserDevices']);
    Route::get('device/history/{machineId}', [DeviceController::class, 'getHistoryByMachineId']);
    Route::get('device/{id}/history/{userId}', [DeviceController::class, 'getHistoryByMachineId']);
    Route::get('device/predict', [DeviceController::class, 'predictOneWeek']);
    Route::get('device/exsmoth', [DeviceController::class, 'predictThreeDays']);
    Route::get('device/weather/evaluate', [DeviceController::class, 'evaluateWeatherConditions']);
    Route::get('device/weather/rainy', [DeviceController::class, 'showRainyConditions']);
    // Route::post('device/logs', [DeviceController::class, 'createLogs']);
});