<?php

namespace App\Http\Controllers\Admin;


use File;
use App\Http\Controllers\Controller;
use App\Interfaces\VehicleInterface;
use App\Interfaces\GrainInterface;
use App\Interfaces\SupplierInterface;
use App\Interfaces\WarehouseInterface;
use App\Interfaces\SecurityCheckInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;

class AdminWarehouseController extends Controller
{
    private $grainRepository;
    private $supplierRepository;
    private $warehouseRepository;
    private $securityCheckRepository;
    public function __construct(GrainInterface $grainRepository, WarehouseInterface $warehouseRepository, SupplierInterface $supplierRepository,SecurityCheckInterface $securityCheckRepository)
    {
        $this->grainRepository = $grainRepository;
        $this->supplierRepository = $supplierRepository;
        $this->warehouseRepository = $warehouseRepository;
        $this->securityCheckRepository = $securityCheckRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $warehouses=$this->warehouseRepository->getWarehouses();
        $suppliers = $this->supplierRepository->getActiveSuppliers();
        $filters=request()->all('search','showing');
        return inertia::render('admin/warehouse/index', compact(
            'warehouses',
            'filters',
            'suppliers'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $grains = $this->grainRepository->getGrains();
        $suppliers= $this->securityCheckRepository->getSecurityChecks();
        return inertia::render('admin/warehouse/create',compact('suppliers','grains'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated=$request->validate([
            'supplier'=>'required|integer|exists:suppliers,id',
            'no_of_bags'=>'required',
            'moisture_content' => 'required',
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
        $suppliers = $this->supplierRepository->getSuppliers();
        return inertia::render('admin/warehouse/edit', compact('warehouse', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated=$request->validate([
            'supplier' => 'required|integer|exists:suppliers,id',
            'vehicle_reg_no' => 'required',
            'vehicle' => 'required|integer|exists:vehicles,id',
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
}
