<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminDriverController;
use App\Http\Controllers\Admin\AdminVehicleController;
use App\Http\Controllers\Admin\AdminSecurityCheckController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminSupplierController;
use App\Http\Controllers\Admin\AdminWarehouseController;
use App\Http\Controllers\Admin\AdminWeighbridgeController;
use App\Http\Controllers\Admin\AdminRolesController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['auth','verified','update_password','role:Admin']], function (){
    Route::resource('admin/drivers', AdminDriverController::class);
    Route::resource('admin/vehicles', AdminVehicleController::class);
    Route::resource('admin/suppliers', AdminSupplierController::class);
    Route::post('/manager/delivery/step-two', [AdminSecurityCheckController::class,'stepTwo'])->name('delivery.step-two');
    Route::post('/manager/delivery/step-one', [AdminSecurityCheckController::class,'stepOne'])->name('delivery.step-one');
    Route::resource('admin/delivery', AdminSecurityCheckController::class);
    Route::resource('admin/warehouse', AdminWarehouseController::class);
    Route::resource('admin/weighbridge', AdminWeighbridgeController::class);
    Route::resource('admin/users',AdminUserController::class,['names' => 'admin.users']);
    Route::post('admin/roles/permission', [AdminRolesController::class, 'permission'])->name('admin.roles.permission');
    Route::resource('admin/roles', AdminRolesController::class, ['names' => 'admin.roles']);
    Route::resource('admin',AdminController::class);
});
