<?php

use App\Http\Controllers\API\DeviceController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\SosMapsController;
use App\Http\Controllers\API\NTMainController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/device/store/Jklame)923l!@kj2k3;Lk', [DeviceController::class, 'createLogs']);
Route::post('/sos/store/UI8iqknk(@_28HJsdplkmaj2xcI@jasi', [SosMapsController::class, 'createSos']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Device logs routes
    Route::get('user-devices/{userId}', [DeviceController::class, 'getUserDevices']);
    Route::get('device/history/{machineId}', [DeviceController::class, 'getHistoryByMachineId']);
    // Route::get('device/{id}/history/{userId}', [DeviceController::class, 'getHistoryByMachineId']);
    Route::get('device/predict', [DeviceController::class, 'predictOneWeek']);
    Route::get('device/exsmoth/{machineId}', [DeviceController::class, 'predictThreeDays']);
    Route::get('device/weather/evaluate', [DeviceController::class, 'evaluateWeatherConditions']);
    Route::get('device/weather/rainy/{machineId}', [DeviceController::class, 'showRainyConditions']);
    // Route::post('device/logs', [DeviceController::class, 'createLogs']);
});

// Navilatech Public routes machine
Route::post('/machine/s/dI6Z1BuI9GnxvTULcA6sT1ugRsCbnE', [NTMainController::class, 'createMachine']);
Route::post('/sm-pt/s/haGshEtFEQWaA5GhCEJp47yzpVrP8GbU1', [SosMapsController::class, 'createSos']);

// Navilatech protected
Route::post('/dsm-pt/d/kjhi89KJo0iwkKjdiaqxmnKAoqwma', [SosMapsController::class, 'createSosDetail']);
Route::post('/md/s/KJoikJNLjlakmnalOIEkalksjdKKnLKJek', [SosMapsController::class, 'createSosDevice']);
Route::post('/device/s/AlKVNKvnZ2t6mq57KkkCEuXp2fFoTs', [NTMainController::class, 'createDarurat']);
Route::post('/verify/WKJlaksAKJlMNBKoiqwueanmncoae', [NTMainController::class, 'verifyAccessToken']);