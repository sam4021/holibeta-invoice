<?php

namespace App\Http\Controllers\Admin;


use File;
use App\Http\Controllers\Controller;
use App\Interfaces\VehicleInterface;
use App\Interfaces\GrainInterface;
use App\Interfaces\QualityControlInterface;
use App\Interfaces\WarehouseInterface;
use App\Interfaces\SecurityCheckInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Reports;

use Milon\Barcode\DNS2D;

class AdminWarehouseController extends Controller
{
    private $grainRepository;
    private $qcRepository;
    private $warehouseRepository;
    private $securityCheckRepository;
    public function __construct(GrainInterface $grainRepository, WarehouseInterface $warehouseRepository, QualityControlInterface $qcRepository,SecurityCheckInterface $securityCheckRepository)
    {
        $this->grainRepository = $grainRepository;
        $this->qcRepository = $qcRepository;
        $this->warehouseRepository = $warehouseRepository;
        $this->securityCheckRepository = $securityCheckRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $warehouses=$this->warehouseRepository->getWarehouses();
        $qcs = $this->qcRepository->getAllQualityControls();
        $filters=request()->all('search','showing');
        return inertia::render('admin/warehouse/index', compact(
            'warehouses',
            'filters',
            'qcs'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $grains = $this->grainRepository->getGrains();
        $qcs = $this->qcRepository->getEmptyQualityControls();
        return inertia::render('admin/warehouse/create',compact('qcs','grains'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated=$request->validate([
            'quality_control'=> 'required|integer|exists:quality_controls,id',
            'no_of_bags'=>'required',
            'bags'=>'required|array',
        ]);
        $validated['created_by'] = Auth::user()->id;
        $warehouse=$this->warehouseRepository->createWarehouse($validated);
        if($warehouse->status()==200){
            return redirect()->route('warehouse.index')->with('success', 'Warehouse added successfully');
        }else{
            return redirect()->back()->with('status', 'Error adding a Warehouse');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $warehouse = $this->warehouseRepository->getWarehouseById($id);
        return inertia::render('admin/warehouse/show', compact('warehouse'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $warehouse = $this->warehouseRepository->getWarehouseById($id);
        $qcs = $this->qcRepository->getAllQualityControls();
        return inertia::render('admin/warehouse/edit', compact('warehouse', 'qcs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated=$request->validate([
            'quality_control' => 'required|integer|exists:quality_controls,id',
        ]);

        $warehouse=$this->warehouseRepository->updateWarehouse($validated,$id);
        if ($warehouse->status()==200){
            return redirect()->route('warehouse.index')->with('success', 'warehouse updated successfully');
        }else{
            return redirect()->back()->with('status', 'warehouse could not be updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $warehouse = $this->warehouseRepository->deleteWarehouse($id);
        if ($warehouse->status() == 200) {
            return redirect()->route('warehouse.index')->with('success', 'Warehouse deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Warehouse could not be deleted');
        }
    }

    public function bagDatas()
    {
        $bags = $this->warehouseRepository->getWarehouseBags();
        $grains = $this->warehouseRepository->getUniqueGrains();
        $filters = request()->all('search', 'showing', 'grain');
        return inertia::render('admin/warehouse/bags', compact(
            'bags',
            'filters',
            'grains'
        ));
    }

    public function bagData($id)
    {
        // dd(DNS2D::getBarcodeHTML('4445645656', 'QRCODE'));
        $bag = $this->warehouseRepository->getWarehouseBag($id);
        return inertia::render('admin/warehouse/bag', compact(
            'bag'
        ));
    }

    public function exportData($format)
    {
        
        $warehouses = $this->warehouseRepository->getWarehouses();
        $data = [
            'warehouses' => $warehouses
        ];
        
        return Reports::generate($format, 'reports.warehouse', $data, 'Warehouse');
    }
}
