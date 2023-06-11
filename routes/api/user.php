<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\LoginController;
use App\Http\Controllers\API\User\LoginController;
use App\Http\Controllers\API\User\MedicineController;
use App\Http\Controllers\API\User\ListController;
use App\Http\Controllers\API\User\ShoppingController;
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
//
Route::post('user/register', [LoginController::class, "register"]);
Route::post('user/login', [LoginController::class, "login"]);

Route::middleware(['auth:user-api','scopes:user'])->group(function () {
    Route::group(["namespace" => "user", "prefix" => "user"], function () {
        Route::group(["namespace" => "list", "prefix" => "list"], function (){
           Route::get("pharmacy/{address}", [ListController::class, "pharmacyList"]);
           Route::get("prescription", [ListController::class, "prescriptionList"]);
           Route::get("category/{pharmacy_id}", [ListController::class, "categoryList"]);
           Route::get("sub_category/{category_id}", [ListController::class, "subCategoryList"]);
           Route::get("non_medicine/{sub_category}/{pharmacy_id}", [ListController::class, "nonMedicineList"]);
        });

        Route::group(["namespace" => "medicine", "prefix" => "medicine"], function () {
            Route::get("search/{pharmacy_id}", [MedicineController::class, "searchMedicine"]);
            Route::get("prescription/{pharmacy_id}/{name}", [MedicineController::class, "prescriptionDetail"]);
        });

        Route::group(["namespace" => "shopping", "prefix" => "shopping"], function () {
            Route::get("basket", [ShoppingController::class, "basketDetail"]);
            Route::get("order/{order_id}", [ShoppingController::class, "orderDetail"]);
            Route::post("add", [ShoppingController::class, "addBasket"]);
            Route::post("buy/{basket_id}", [ShoppingController::class, "buyBasket"]);
            Route::post("cancel/{order_id}", [ShoppingController::class, "cancelOrder"]);
        });

        Route::group(["namespace" => "location", "prefix" => "location"], function () {
            Route::get("city", [ListController::class, "cityList"]);
            Route::get("district", [ListController::class, "districtList"]);
            Route::get("address", [ListController::class, "addressList"]);
        });
    });
});
