<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminVehicleController;
use App\Http\Controllers\Admin\AdminSecurityCheckController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminSupplierController;
use App\Http\Controllers\Admin\AdminShiftController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['auth','verified','update_password','role:Admin']], function (){
    Route::resource('admin/vehicles', AdminVehicleController::class);
    Route::resource('admin/suppliers', AdminSupplierController::class);
    Route::resource('admin/security-check', AdminSecurityCheckController::class);
    Route::resource('admin/users',AdminUserController::class,['names' => 'admin.users']);
    Route::resource('admin',AdminController::class);
});
