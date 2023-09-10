<?php

use App\Http\Controllers\Supervisor\SupervisorController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['auth','verified','update_password']], function (){
    Route::resource('supervisor',SupervisorController::class);
});
