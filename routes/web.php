<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminRolesController;
use App\Http\Controllers\Admin\AdminInvoiceController;
use App\Http\Controllers\Admin\AdminCustomerController;

use App\Http\Controllers\Admin\AdminTransactionController;
use App\Http\Controllers\Admin\AdminVatController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [MainController::class, 'home'])->name('login')->middleware('guest');


require __DIR__.'/auth.php';

Route::prefix('admin')->group(function () {
    Route::group(['middleware' => ['auth', 'verified', 'update_password']], function () {
        Route::resource('users', AdminUserController::class, ['names' => 'admin.users']);
        Route::post('roles/permission', [AdminRolesController::class, 'permission'])->name('admin.roles.permission');
        Route::resource('roles', AdminRolesController::class, ['names' => 'admin.roles']);

        Route::resource('invoice', AdminInvoiceController::class, ['names' => 'invoice']);
        Route::resource('customer', AdminCustomerController::class, ['names' => 'customer']);
        
    Route::resource('admin/transactions', AdminTransactionController::class);
    Route::resource('admin/vat', AdminVatController::class);

        Route::resource('/', AdminController::class, ['names' => 'admin']);
    });
});
