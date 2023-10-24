<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Machine;
use App\Models\Product;
use App\Models\Shift;
use App\Interfaces\SecurityCheckInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class AdminSecurityCheckController extends Controller
{
    private $securityCheckRepository;
    public function __construct(SecurityCheckInterface $securityCheckRepository)
    {
        $this->securityCheckRepository=$securityCheckRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $securityChecks=$this->securityCheckRepository->getSecurityChecks();
        $filters=request()->all('search','showing','shift','machine');
        return inertia::render('admin/security-check/index', compact(
            'securityChecks',
            'filters',
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $suppliers=Suppliers::select('id','name')->get();
        $vehicles=Vehicle::select('id','name')->get();
        return inertia::render('admin/security-check/create',compact('suppliers','vehicles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated=$request->validate([
            'supplier'=>'required|integer|exists:suppliers,id', 
            'vehicle_reg_no'=>'required', 
            'vehicle_id'=>'required|integer|exists:vehicles,id', 
            'front_image'=>'required', 
            'back_image'=>'required', 
            'side_image'=>'required'
        ]);
        $validated['created_by'] = Auth::user()->id;
        $securityCheck=$this->securityCheckRepository->createSecurityCheck($validated);
        if($securityChecks->status()==200){
            return redirect()->route('security-check.index')->with('success','Security Check added successfully');
        }else{
            return redirect()->back()->with('status','Error adding a Security Check');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
