<?php

use App\Http\Controllers\API\User\ShoppingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\LoginController;
use App\Http\Controllers\API\Pharmacy\LoginController;
use App\Http\Controllers\API\Pharmacy\MedicineController;
use App\Http\Controllers\API\Pharmacy\OrderController;
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
Route::post("pharmacy/register", [LoginController::class, "register"]);
Route::post('pharmacy/login', [LoginController::class, "login"]);


Route::middleware(['auth:pharmacy-api','scopes:pharmacy'])->group(function () {
        Route::group(["namespace" => "pharmacy", "prefix" => "pharmacy"], function () {
            Route::post("add_carrier", [LoginController::class, "addCarrier"]);

            Route::group(["namespace" => "medicine", "prefix" => "medicine"], function () {
                Route::get("category", [MedicineController::class, "medicineCategoryList"]); // kategori listesi
                Route::get("sub_category/{category_id}", [MedicineController::class, "medicineSubCategoryList"]); // kategori listesi
                Route::get("list/{sub_category_id}", [MedicineController::class, "medicineList"]); ; // ilaç listesi
                Route::post("add", [MedicineController::class, "medicineAdd"]); ; // ilaç listesi
            });
            Route::group(["namespace" => "non_medical", "prefix" => "non_medical"], function (){
                Route::get("category", [MedicineController::class, "nonMedicalCategoryList"]); // medikal almayan kategori listesi
                Route::get("sub_category/{category_id}", [MedicineController::class, "nonMedicalSubCategoryList"]); // medikal almayan alt kategori listesi
                Route::get("list/{sub_medical_id}", [MedicineController::class, "nonMedicalList"]); // medikal almayan ilaç listesi
                Route::post("add", [MedicineController::class, "nonMedicalAdd"]); // medikal almayan ilaç ekleme
            });
            Route::group(["namespace" => "order", "prefix" => "order"], function () {
               Route::get("list", [OrderController::class, "orderList"]);
               Route::get("{order_id}", [ShoppingController::class, "orderDetail"]);
               Route::post("update/{order_id}", [OrderController::class, "orderUpdate"]);
            });
            Route::group(["namespace" => "list","prefix" => "list"], function () {
                Route::get("courriers",[OrderController::class, "currierList"]);
            });
        });
});
