<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\SaleInvoiceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::group(['prefix' => 'v1','middleware' => 'auth:sanctum'], function () {
    Route::resource('product', ProductController::class);
    Route::resource('product-categories', ProductCategoryController::class);
    Route::resource('staff', StaffController::class);
    Route::resource('shop', ShopController::class);
    Route::get('sale-invoices/get-by-voucher/{voucher_no}', [SaleInvoiceController::class, 'getDataByVoucherNo']);
    Route::resource('sale-invoices', SaleInvoiceController::class);
    // Route::get('product', [ProductController::class, 'index']);


    Route::resource('customer', CustomerController::class);

});
