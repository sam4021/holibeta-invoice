<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminMachineController;
use App\Http\Controllers\Admin\AdminProducts;
use App\Http\Controllers\Admin\AdminShiftController;
use Illuminate\Support\Facades\Route;

Route::group([], function (){
    Route::resource('admin/products',AdminProducts::class);
    Route::resource('admin/shifts',AdminShiftController::class);
    Route::resource('admin/machines',AdminMachineController::class);
    Route::resource('admin',AdminController::class);
});
