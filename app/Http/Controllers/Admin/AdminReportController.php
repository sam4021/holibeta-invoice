<?php

namespace App\Http\Controllers\Admin;

use File;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Enums\RoleEnum;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;
use App\Models\Reports;

class AdminReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:' . RoleEnum::Admin->value]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = DB::table('suppliers')->select(
            'id',
            DB::raw("CONCAT(firstname,' ',lastname) as name")
        )->get();
        $drivers = DB::table('drivers')->select(
            'id',
            DB::raw("CONCAT(firstname,' ',lastname) as name")
        )->get();
        $reports = DB::table('warehouse_bags')
            ->when(request('search'), function ($query) {
                $query->where('warehouse_bags.bag_code', 'like', '%' . request('search') . '%');
            })
            ->when(request('supplier'), function ($query) {
                $query->where('suppliers.id', request('supplier'));
            })
            ->when(request('driver'), function ($query) {
                $query->where('drivers.id', request('driver'));
            })
            ->join('grains', 'grains.id', 'warehouse_bags.grain_id')
            ->join('warehouses', 'warehouses.id', 'warehouse_bags.warehouse_id')
            ->join('quality_controls', 'quality_controls.id', 'warehouses.quality_control_id')
            ->join('weighbridges', 'weighbridges.id', 'quality_controls.weighbridge_id')
            ->join('security_checks', 'security_checks.id', 'weighbridges.delivery_id')
            ->join('suppliers', 'suppliers.id', 'security_checks.supplier_id')
            ->join('drivers', 'drivers.id', 'security_checks.driver_id')
            ->select([
                'warehouse_bags.id as bag_id',
                'warehouse_bags.bag_code',
                'warehouse_bags.weight',
                'warehouses.id as warehouse_id',
                'warehouses.warehouse_code',
                'quality_controls.id as qc_id',
                'quality_controls.qc_code as qc_code',
                'weighbridges.id as weighbridge_id',
                'weighbridges.weighbridge_code as weighbridge_code',
                'security_checks.id as d_id',
                'security_checks.security_check_code as d_code',
                'suppliers.id as supplier_id',
                DB::raw("CONCAT(suppliers.firstname,' ',suppliers.lastname) as fullname"),
                'drivers.id as driver_id',
                DB::raw("CONCAT(drivers.firstname,' ',drivers.lastname) as driver_name")
            ])
            ->paginate(request('showing') ?? 10);
        $filters = request()->all('search', 'showing', 'supplier');

        return inertia::render('admin/reports/index', compact('reports', 'filters', 'suppliers', 'drivers'));
    }

    public function exportData($format)
    {
        $reports = DB::table('warehouse_bags')
            ->when(request('search'), function ($query) {
                $query->where('warehouse_bags.bag_code', 'like', '%' . request('search') . '%');
            })
            ->when(request('supplier'), function ($query) {
                $query->where('suppliers.id', request('supplier'));
            })
            ->when(request('driver'), function ($query) {
                $query->where('drivers.id', request('driver'));
            })
            ->join('grains', 'grains.id', 'warehouse_bags.grain_id')
            ->join('warehouses', 'warehouses.id', 'warehouse_bags.warehouse_id')
            ->join('quality_controls', 'quality_controls.id', 'warehouses.quality_control_id')
            ->join('weighbridges', 'weighbridges.id', 'quality_controls.weighbridge_id')
            ->join('security_checks', 'security_checks.id', 'weighbridges.delivery_id')
            ->join('suppliers', 'suppliers.id', 'security_checks.supplier_id')
            ->join('drivers', 'drivers.id', 'security_checks.driver_id')
            ->select([
                'warehouse_bags.id as bag_id',
                'warehouse_bags.bag_code',
                'warehouse_bags.weight',
                'warehouses.id as warehouse_id',
                'warehouses.warehouse_code',
                'quality_controls.id as qc_id',
                'quality_controls.qc_code as qc_code',
                'weighbridges.id as weighbridge_id',
                'weighbridges.weighbridge_code as weighbridge_code',
                'security_checks.id as d_id',
                'security_checks.security_check_code as d_code',
                'suppliers.id as supplier_id',
                DB::raw("CONCAT(suppliers.firstname,' ',suppliers.lastname) as fullname"),
                'drivers.id as driver_id',
                DB::raw("CONCAT(drivers.firstname,' ',drivers.lastname) as driver_name")
            ])
            ->get();
        $data = [
            'reports' => $reports
        ];

        return Reports::generate($format, 'reports.reports', $data, 'Report');
    }
}
