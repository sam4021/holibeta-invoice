<?php

namespace App\Http\Controllers\Admin;


use File;
use App\Http\Controllers\Controller;
use App\Interfaces\SupplierInterface;
use App\Interfaces\WeighbridgeInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;

class AdminWeighbridgeController extends Controller
{
    private $supplierRepository;
    private $weighbridgeRepository;
    public function __construct(SupplierInterface $supplierRepository, WeighbridgeInterface $weighbridgeRepository)
    {
        $this->supplierRepository = $supplierRepository;
        $this->weighbridgeRepository = $weighbridgeRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $weighbridges=$this->weighbridgeRepository->getWeighbridges();
        $filters=request()->all('search','showing','shift','machine');
        $suppliers = $this->supplierRepository->getSuppliers();
        return inertia::render('admin/weighbridge/index', compact(
            'weighbridges',
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
        $suppliers= $this->supplierRepository->getSuppliers();
        return inertia::render('admin/weighbridge/create',compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated=$request->validate([
            'supplier'=>'required|integer|exists:suppliers,id', 
            'weight'=>'required',
            'moisture_content'=>'required'
        ]);
        $validated['created_by'] = Auth::user()->id;
        $weighbridge=$this->weighbridgeRepository->createWeighbridge($validated);
        if($weighbridge->status()==200){
            return redirect()->route('weighbridge.index')->with('success', 'Weighbridge added successfully');
        }else{
            return redirect()->back()->with('status', 'Error adding a Weighbridge');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $weighbridge = $this->weighbridgeRepository->getWeighbridgeById($id);
        return inertia::render('admin/weighbridge/show', compact('weighbridge'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $weighbridge = $this->weighbridgeRepository->getWeighbridgeById($id);
        $suppliers = $this->supplierRepository->getSuppliers();
        return inertia::render('admin/weighbridge/edit', compact('weighbridge', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated=$request->validate([
            'supplier' => 'required|integer|exists:suppliers,id',
            'weight' => 'required',
            'moisture_content'=>'required',
        ]);

        $weighbridge=$this->weighbridgeRepository->updateWeighbridge($validated,$id);
        if ($weighbridge->status()==200){
            return redirect()->route('weighbridge.index')->with('success', 'Weighbridge updated successfully');
        }else{
            return redirect()->back()->with('status', 'Weighbridge could not be updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $weighbridge = $this->weighbridgeRepository->deleteWeighbridge($id);
        if ($weighbridge->status() == 200) {
            return redirect()->route('weighbridge.index')->with('success', 'Weighbridge deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Weighbridge could not be deleted');
        }
    }
}
