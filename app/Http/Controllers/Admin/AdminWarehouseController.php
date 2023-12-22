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
use App\Models\Warehouse;
use Milon\Barcode\Facades\DNS2DFacade as DNS2D;
use App\Http\Resources\WarehouseResource;
use App\Models\WarehouseBags;
use Illuminate\Support\Facades\DB;



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
        // $grains = $this->grainRepository->getGrains();
        $qcs = $this->qcRepository->getEmptyQualityControls();
        return inertia::render('admin/warehouse/create',compact('qcs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
        $qrcode = DNS2D::getBarcodeHTML('4445645656', 'QRCODE');
        $bag = $this->warehouseRepository->getWarehouseBag($id);
        return inertia::render('admin/warehouse/bag', compact(
            'bag',
            'qrcode'
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

    public function bagAdd ($id)
    {
        $warehouse = $this->warehouseRepository->getWarehouseById($id);
        return inertia::render('admin/warehouse/bag_add', compact('warehouse'));
    }

    public function bagStore(Request $request,$id)
    {
        $validated = $request->validate([
            'no_of_bags' => 'required',
            'bags' => 'required|array',
        ]);
        $validated['created_by'] = Auth::user()->id;
        $warehouse = $this->warehouseRepository->addWarehouseBags($id, $validated);
        if ($warehouse->status() == 200) {
            return redirect()->route('warehouse.index')->with('success', 'Warehouse added successfully');
        } else {
            return redirect()->back()->with('status', 'Error adding a Warehouse');
        }
    }

    public function bagPdf($id)
    {
        $bag =  DB::table('warehouse_bags')
                    ->join('users as bagUser', 'bagUser.id', 'warehouse_bags.created_by')
                    ->join('warehouses', 'warehouses.id', 'warehouse_bags.warehouse_id')
                    ->join('users as warehouseUser', 'warehouseUser.id', 'warehouses.created_by')
                    ->join('quality_controls', 'quality_controls.id', 'warehouses.quality_control_id')
                    ->join('users as qcUser', 'qcUser.id', 'quality_controls.created_by')
                    ->join('weighbridges', 'weighbridges.id', 'quality_controls.weighbridge_id')
                    ->join('users as weighbridgeUser', 'weighbridgeUser.id', 'weighbridges.created_by')
                    ->join('security_checks', 'security_checks.id', 'weighbridges.delivery_id')
                    ->join('users as deliveryUser', 'deliveryUser.id', 'security_checks.created_by')
                    ->join('suppliers', 'suppliers.id', 'weighbridges.supplier_id')
                    ->join('drivers', 'drivers.id', 'security_checks.driver_id')
                    ->join('counties', 'counties.id', 'security_checks.county_id')
                    ->join('subcounties', 'subcounties.id', 'security_checks.subcounty_id')
                    ->join('grains', 'grains.id', 'warehouse_bags.grain_id')
                    ->select(
                        'warehouse_bags.bag_code',
                        'bagUser.name as bag_creator',
                        'warehouse_bags.weight',
                        'grains.name as grain',
                        'warehouse_bags.created_at as bag_date',
                        'warehouses.warehouse_code',
                        'warehouseUser.name as warehouse_creator', 
                        'warehouses.no_of_bags',
                        'warehouses.created_at as warehouse_date',
                        'quality_controls.qc_code',
                        'qcUser.name as qc_creator',
                        'quality_controls.visual_inspection',
                        'quality_controls.visual_inspection_comment',
                        'quality_controls.visual_inspection_image',
                        'quality_controls.moisture_content',
                        'quality_controls.aflatoxin_content',
                        'quality_controls.created_at as qc_date',
                        'weighbridges.weighbridge_code',
                        'suppliers.supplier_code',
                        'suppliers.firstname as supplier_firstname',
                        'suppliers.middlename as supplier_middlename',
                        'suppliers.lastname as supplier_lastname',
                        'weighbridgeUser.name as weigh_creator',
                        'weighbridges.weight',
                        'weighbridges.created_at as weigh_date',
                        'security_checks.security_check_code',
                        'deliveryUser.name as delivery_creator' ,
                        'security_checks.vehicle_type',
                        'security_checks.vehicle_reg_no',
                        'drivers.firstname as driver_firstname',
                        'drivers.middlename as driver_middlename', 
                        'drivers.lastname as driver_lastname',
                        'counties.name as delivery_county',
                        'subcounties.name as delivery_subcounty',
                        'security_checks.village',
                        'security_checks.created_at as delivery_date',
                        'security_checks.no_of_bags as delivery_bags'
                        )
                    ->where('warehouse_bags.id',$id)
                    ->get()->first();
 
        // WarehouseBags::with(['warehouse', 'createdBy', 'grain', 'qualityControl', 'weighbridge', 'delivery', 'supplier', 'driver', 'status'])->find($id);
        $pdfData = [
            'info' => $bag
        ];
        
        return Reports::generate('pdf', 'reports.bag', $pdfData, $bag->bag_code);
    }
}
