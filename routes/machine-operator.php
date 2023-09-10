<?php

use App\Http\Controllers\MachineOperator\MachineOperatorController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['auth','verified','update_password']], function (){
    Route::resource('machine-operator',MachineOperatorController::class);
});
