<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Admin\LoginController;
use App\Http\Controllers\API\Admin\ManagementController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('admin/register', [LoginController::class, "register"]);
Route::post('admin/login', [LoginController::class, "login"]);

Route::middleware(['auth:admin-api','scopes:admin'])->group(function () {
    Route::group(["namespace" => "admin", "prefix" => "admin"], function () {
        Route::get("pharmacy_list", [ManagementController::class, "pharmacyList"]);
        Route::get("accept/{pharmacy_id}", [ManagementController::class, "pharmacyAccept"]);
        Route::get("delete/{pharmacy_id}", [ManagementController::class, "pharmacyDelete"]);
    });
});
