<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Interfaces\VehicleInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Enums\RoleEnum;
use Illuminate\Support\Facades\Auth;

class AdminVehicleController extends Controller
{
    private VehicleInterface $vehicleRepository;

    public function __construct(VehicleInterface $vehicleRepository){
        $this->vehicleRepository= $vehicleRepository;
        $this->middleware(['role:'.RoleEnum::Admin->value]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $vehicles=$this->vehicleRepository->getVehicles();
        $filters = request()->all('search', 'showing');

        return inertia::render('admin/vehicles/index', compact('vehicles','filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $validated=$request->validate([
            'name'=>'required|string|max:125',
        ]);
        $validated['created_by'] = Auth::user()->id;
        $vehicle=$this->vehicleRepository->storeVehicle($validated);

        if ($vehicle->status()==200) {
            return redirect()->back()->with('success', 'Vehicle created successfully');
        } else {
            return redirect()->back()->with('status', 'Vehicle creation failed');
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
        $validated=$request->validate([
            'name'=>'required|string|max:125',
            'status'=>'required|string',
        ]);
        $vehicle=$this->vehicleRepository->updateVehicle($validated,$id);
        if ($vehicle['status']==200) {
            return redirect()->back()->with('success', $vehicle['message']);
        } else {
            return redirect()->back()->with('status', $vehicle['message']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

        $vehicle=$this->vehicleRepository->deleteVehicle($id);
        if ($vehicle->status()==200) {
            return redirect()->back()->with('success', 'Vehicle deleted successfully');
        } else {
            return redirect()->back()->with('status', 'Vehicle deletion failed');
        }
    }
}
