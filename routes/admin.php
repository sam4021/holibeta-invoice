<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminGrainController;
use App\Http\Controllers\Admin\AdminQualityControlController;
use App\Http\Controllers\Admin\AdminDriverController;
use App\Http\Controllers\Admin\AdminVehicleController;
use App\Http\Controllers\Admin\AdminSecurityCheckController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminSupplierController;
use App\Http\Controllers\Admin\AdminWarehouseController;
use App\Http\Controllers\Admin\AdminWeighbridgeController;
use App\Http\Controllers\Admin\AdminRolesController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'verified', 'update_password']], function () {
    Route::get('admin/report/grain', [AdminReportController::class, 'grain'])->name('report.grain');
    Route::get('admin/report/report/{format}', [AdminReportController::class, 'exportData'])->name('reports.report');
    Route::get('admin/report', [AdminReportController::class, 'index'])->name('reports');
    Route::resource('admin/grains', AdminGrainController::class);
    Route::resource('admin/drivers', AdminDriverController::class);
    Route::resource('admin/vehicles', AdminVehicleController::class);
    Route::resource('admin/suppliers', AdminSupplierController::class);
    Route::post('/manager/delivery/step-two', [AdminSecurityCheckController::class, 'stepTwo'])->name('delivery.step-two');
    Route::post('/manager/delivery/step-one', [AdminSecurityCheckController::class, 'stepOne'])->name('delivery.step-one');
    Route::resource('admin/delivery', AdminSecurityCheckController::class);
    Route::get('admin/warehouse/bags/add/{warehouse}', [AdminWarehouseController::class, 'bagAdd'])->name('warehouse.bags.add');
    Route::post('admin/warehouse/bags/store/{warehouse}', [AdminWarehouseController::class, 'bagStore'])->name('warehouse.bags.store');
    Route::get('admin/warehouse/bags', [AdminWarehouseController::class, 'bagDatas'])->name('warehouse.bags');
    Route::get('admin/warehouse/bags/report/{format}', [AdminWarehouseController::class, 'bagDatasExport'])->name('warehouse.bags.report');
    Route::get('admin/warehouse/bag/{id}', [AdminWarehouseController::class, 'bagData'])->name('warehouse.bag');
    Route::get('admin/warehouse/bag/pdf/{id}', [AdminWarehouseController::class, 'bagPdf'])->name('warehouse.bag.pdf');
    Route::get('admin/warehouse/report/{format}', [AdminWarehouseController::class, 'exportData'])->name('warehouse.report');
    Route::get('admin/warehouse/export/bags/{id}', [AdminWarehouseController::class, 'exportBags'])->name('warehouse.export.bags');
    Route::resource('admin/warehouse', AdminWarehouseController::class);
    Route::resource('admin/weighbridge', AdminWeighbridgeController::class);
    Route::resource('admin/quality-control', AdminQualityControlController::class);
    Route::resource('admin/users', AdminUserController::class, ['names' => 'admin.users']);
    Route::post('admin/roles/permission', [AdminRolesController::class, 'permission'])->name('admin.roles.permission');
    Route::resource('admin/roles', AdminRolesController::class, ['names' => 'admin.roles']);
    Route::resource('admin', AdminController::class);
});

Route::get('test-bag-pdf', function () {
    $warehouseData = \App\Models\Warehouse::find($id);
        $bagsData = \App\Models\WarehouseBags::where('warehouse_id', 1);
        $pdfData = [
            'info' => $bagsData
        ];
            
        return Reports::generate('excel', 'reports.warehousebags', $pdfData, $warehouseData->warehouse_code);

    // $bag = \App\Models\WarehouseBags::with(['warehouse', 'createdBy', 'grain', 'weighbridge', 'delivery', 'supplier', 'driver', 'status'])->find(1);
    // $pdfData = [
    //     'info' => $bag,
    //     'qc' => $bag->qualityControl
    // ];
    // // dd($pdfData);
    // $pdf = \Barryvdh\DomPDF\Facade\PDF::loadView('reports.bag', $pdfData)->setOption(['defaultFont' => 'sans-serif'])
    //     ->setPaper('a4', 'portrait');
    // $pdf->setOption('javascript-delay', 30000);
    // $pdf->setOption('isHtml5ParserEnabled', true);
    // $pdf->setOption('isRemoteEnabled', true);
    // return $pdf->stream();
    // Storage::disk('public')->put('pdfs/transactions/' . $invoiceName . '.pdf', $pdf->output());
});
