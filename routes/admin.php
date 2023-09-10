<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminMachineController;
use Illuminate\Support\Facades\Route;

Route::group([], function (){
    Route::resource('admin/machines',AdminMachineController::class);
    Route::resource('admin',AdminController::class);
});
