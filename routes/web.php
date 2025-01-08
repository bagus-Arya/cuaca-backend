<?php

use App\Http\Controllers\Admin\CreateMachineController;
use App\Http\Controllers\Admin\CreateUserController;
use App\Http\Controllers\Admin\DeleteMachineController;
use App\Http\Controllers\Admin\DeleteUserController;
use App\Http\Controllers\Admin\EditMachineController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\LandingPageController;
use App\Http\Controllers\Admin\LoginAuthController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\LogoutController;
use App\Http\Controllers\Admin\MachineController;
use App\Http\Controllers\Admin\MachineLogsController;
use App\Http\Controllers\Admin\ShowCreateMachineController;
use App\Http\Controllers\Admin\ShowCreateUserController;
use App\Http\Controllers\Admin\ShowEditMachineController;
use App\Http\Controllers\Admin\ShowMachineController;
use App\Http\Controllers\Admin\ShowMachineLogsController;
use App\Http\Controllers\Admin\ShowUserController;
use App\Http\Controllers\Admin\CreateUserDeviceController;
use App\Http\Controllers\Admin\RemoveUserDeviceController;
use App\Http\Controllers\ShowEditUserController;
use App\Http\Controllers\Admin\ShowSosMapsController;
use App\Http\Controllers\Admin\EditUserController;
use App\Http\Controllers\API\MachineLogController;
use App\Http\Controllers\Navilatech\NTHomeController;
use App\Http\Controllers\Navilatech\NTShowGroupController;
use App\Http\Controllers\Navilatech\NTShowCreateGroupController;
use App\Http\Controllers\Navilatech\NTCreateGroupController;
use App\Http\Controllers\Navilatech\NTCreateUserGroupController;
use App\Http\Controllers\Navilatech\NTShowAddGroupUserController;
use App\Http\Controllers\Navilatech\NTListGroupUserController;
use App\Http\Controllers\Navilatech\NTShowEditGroupController;
use App\Http\Controllers\Navilatech\NTEditGroupController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/logout", LogoutController::class) -> name('logout');
Route::prefix("/login") -> group(function() {
    Route::get("/", LoginController::class) -> name('show-login');
    Route::post("/", LoginAuthController::class) -> name('login');
});

Route::group(["prefix" => "user", "middleware" => ["auth"]], function() {
    Route::get("/", HomeController::class) -> name('home');
    Route::get("/show-user", ShowCreateUserController::class) -> name('show-store-user');
    Route::get("/edit/{user:id}", ShowEditUserController::class) -> name('show-edit-user');
    Route::put("/edit/{user:id}", EditUserController::class) -> name('edit-user');
    Route::post("/store-user", CreateUserController::class) -> name('store-user');
    Route::post("/store-user-device", CreateUserDeviceController::class) -> name('store-user-device');
    Route::post("/remove-user-device", RemoveUserDeviceController::class) -> name('remove-user-device');
    Route::get('/user-data', ShowUserController::class) -> name('user-data');
    Route::get('/delete-user-data/{user:id}', DeleteUserController::class) -> name('delete-user-data');
});

// navilatech
Route::group(["prefix" => "nt", "middleware" => ["auth"]], function() {
    Route::get("/", NTHomeController::class) -> name('nthome');
    Route::get("/add/{group:id}", NTShowAddGroupUserController::class) -> name('nt-show-group-user');
    Route::get("/nt-show-user", NTShowCreateGroupController::class) -> name('nt-show-store-user');
    Route::get('/nt-user-data', NTShowGroupController::class) -> name('nt-user-data');
    Route::post("/nt-store-user", NTCreateGroupController::class) -> name('nt-store-user');
    Route::get('/nt-delete-user-data/{user:id}', DeleteUserController::class) -> name('nt-delete-user-data');

    Route::get("/edit/{group:id}", NTShowEditGroupController::class) -> name('show-edit-group');
    Route::put("/edit/{group}", NTEditGroupController::class) -> name('edit-group');

    // group user
    Route::get('/nt-group-data', NTListGroupUserController::class) -> name('nt-group-data');
    Route::post("/nt-store-groups", NTCreateUserGroupController::class) -> name('nt-store-groups');

});

Route::group(["prefix" => "machine", "middleware" => ["auth"]], function() {
    Route::get("/", MachineController::class) -> name('machine');
    Route::get("/data-machine", ShowMachineController::class) -> name('data-machine');
    Route::get("/store", ShowCreateMachineController::class) -> name('show-store-machine');
    Route::get("/delete/{machine:id}", DeleteMachineController::class) -> name('delete-machine-data');
    Route::get("/edit/{machine:id}", ShowEditMachineController::class) -> name('show-edit-machine');
    Route::put("/edit/{machine:id}", EditMachineController::class) -> name('edit-machine');
    Route::post("/store", CreateMachineController::class) -> name('store-machine');
});

Route::group(["prefix" => "logs", "middleware" => ["auth"]], function() {
    Route::get("/", MachineLogsController::class) -> name('machine-logs');
    Route::get("/data-machine-logs", ShowMachineLogsController::class) -> name('data-machine-logs');
});

Route::group(["prefix" => "sosmaps", "middleware" => ["auth"]], function() {
    Route::get("/", ShowSosMapsController::class) -> name('sos-maps');
});


