<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\SupplierResource;
use App\Models\Suppliers;
use App\Models\Shift;
use App\Interfaces\VehicleInterface;
use App\Interfaces\SupplierInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Enums\RoleEnum;
use Illuminate\Support\Facades\Auth;

class AdminSupplierController extends Controller
{
    private $supplierRepository;
    private $vehicleRepository;
    public function __construct(VehicleInterface $vehicleRepository, SupplierInterface $supplierRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
        $this->supplierRepository = $supplierRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $suppliers=$this->supplierRepository->getSuppliers();
        $filters=request()->all('search','showing');
        return inertia::render('admin/suppliers/index', compact('suppliers','filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $vehicles= $this->vehicleRepository->getVehicles();
        return inertia::render('admin/suppliers/create',compact('vehicles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated=$request->validate([
            'firstname'=>'required|string|max:20',
            'middlename'=>'nullable|string|max:20',
            'lastname'=>'required|string|max:20',
            'phone' => 'required|string',
            'email' => 'nullable|string',
            'id_no' => 'nullable|string',
            'county' => 'required|string',
            'subcounty' => 'required|string',
            'ward' => 'required|string',
        ]);
        $validated['created_by'] = Auth::user()->id;
        $supplier=$this->supplierRepository->createSupplier($validated);
        if ($supplier->status()==200){
            return redirect()->route('suppliers.index')->with('success', 'Supplier created successfully');
        }else{
            return redirect()->back()->with('status', 'Supplier could not be created');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $supplier=new SupplierResource(Suppliers::findBySlugOrFail($id));
        return inertia::render('admin/suppliers/show',compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $supplier= Suppliers::findOrFail($id);
        return inertia::render('admin/suppliers/edit',compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        $validated=$request->validate([
            'firstname'=>'required|string|max:20',
           'middlename'=>'nullable|string|max:20',
           'lastname'=>'required|string|max:20',
            'phone' => 'required|string',
            'email' => 'nullable|string',
            'id_no' => 'nullable|string',
            'age_limits' => 'nullable|string'
        ]);

        $supplier=$this->supplierRepository->updateSupplier($validated,$id);
        if ($supplier->status()==200){
            return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully');
        }else{
            return redirect()->back()->with('status', 'Supplier could not be updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $supplier=$this->supplierRepository->deleteSupplier($id);
        if ($supplier->status()==200){
            return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully');
        }else{
            return redirect()->back()->with('error', 'Supplier could not be deleted');
        }
    }

    public function getSuppliers(){
        $suppliers= SupplierResource::collection(Supplier::get());
        return response()->json(['suppliers'=> $suppliers],200);
    }
}
