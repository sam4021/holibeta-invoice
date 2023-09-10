<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminMachineController;
use App\Http\Controllers\Admin\AdminUserController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['auth','verified','update_password']], function (){
    Route::resource('admin/machines',AdminMachineController::class);
    Route::resource('admin/users',AdminUserController::class,['names' => 'admin.users']);
    Route::resource('admin',AdminController::class);
});
