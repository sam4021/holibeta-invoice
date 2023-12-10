<?php

use App\Http\Controllers\Admin\AdminProducts;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get/products',[ApiController::class,'getProducts']);
Route::get('get/counties', [ApiController::class, 'getCounties']);
Route::get('get/sub-counties/{id}', [ApiController::class, 'getSubcounties']);
Route::get('get/default_county', [ApiController::class, 'getDefaultCounty']);
Route::get('get/suppliers/count', [ApiController::class, 'getSuppliersCount']);
Route::get('get/drivers/count', [ApiController::class, 'getDriversCount']);
Route::get('get/grains/count/warehouse', [ApiController::class, 'getGrainsWarehouseCount']);
