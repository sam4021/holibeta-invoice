<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;


Route::group([], function (){
    Route::post('register/creat/user',[AuthController::class, 'creatUser'])->name('create.user');
    Route::get('auth/register',[AuthController::class, 'register'])->name('register');
});


