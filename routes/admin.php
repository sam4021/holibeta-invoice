<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::group([], function (){
    Route::resource('admin',AdminController::class);
});
