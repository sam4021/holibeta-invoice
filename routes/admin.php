<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['auth','verified']], function (){
    Route::resource('admin',AdminController::class);
});
