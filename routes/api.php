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
    
    Route::group(["prefix" => 'device'], function() {
        // Device management
        Route::get('/', [DeviceController::class, 'index']);
        Route::get('/{id}', [DeviceController::class, 'show']);
        Route::post('/create', [DeviceController::class, 'store']);
        Route::put('/{id}', [DeviceController::class, 'update']);
        Route::delete('/{id}', [DeviceController::class, 'destroy']);
        
        // Device monitoring
        Route::get('/logs/{id}', [DeviceController::class, 'getLogs']);
        Route::get('/status/{id}', [DeviceController::class, 'getStatus']);
        Route::get('/statistics/{id}', [DeviceController::class, 'getStatistics']);
        
        // Device control
        Route::post('/activate/{id}', [DeviceController::class, 'activate']);
        Route::post('/deactivate/{id}', [DeviceController::class, 'deactivate']);
        
        // Data operations
        Route::get('/history', [DeviceController::class, 'showRainyConditions']);
        Route::post('/', [DeviceController::class, 'createLogs']);
    });
});