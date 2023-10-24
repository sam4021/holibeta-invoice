<?php

namespace App\Http\Controllers\Admin;


use File;
use App\Http\Controllers\Controller;
use App\Interfaces\VehicleInterface;
use App\Interfaces\SupplierInterface;
use App\Interfaces\SecurityCheckInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;

class AdminSecurityCheckController extends Controller
{
    private $vehicleRepository;
    private $supplierRepository;
    private $securityCheckRepository;
    private $securityPath;
    public function __construct(VehicleInterface $vehicleRepository, SupplierInterface $supplierRepository, SecurityCheckInterface $securityCheckRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
        $this->supplierRepository = $supplierRepository;
        $this->securityCheckRepository = $securityCheckRepository;
        $this->securityPath = public_path() . '/images/security-check/';
        File::isDirectory($this->securityPath) or File::makeDirectory($this->securityPath, 0777, true, true);
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
        $suppliers= $this->supplierRepository->getSuppliers();
        $vehicles= $this->vehicleRepository->getVehicles();
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
            'vehicle'=>'required|integer|exists:vehicles,id', 
            'front_image'=> 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048', 
            'back_image'=> 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048', 
            'side_image'=> 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048' 
        ]);
        $validated['created_by'] = Auth::user()->id;
        if ($request->hasFile('front_image')) {
            $front_image       = $request->file('front_image');
            $extension = $front_image->getClientOriginalExtension();
            $filename = 'front_image_' . time() .'.'.  $extension;
            $image_resize = Image::make($front_image->getRealPath());
            $image_resize->save($this->securityPath . $filename);
            $validated['front_image'] = $filename;
        }
        if ($request->hasFile('back_image')) {
            $back_image       = $request->file('back_image');
            $extension = $back_image->getClientOriginalExtension();
            $filename = 'back_image_' . time() . '.' .  $extension;
            $image_resize = Image::make($back_image->getRealPath());
            $image_resize->save($this->securityPath . $filename);
            $validated['back_image'] = $filename;
        }
        if ($request->hasFile('side_image')) {
            $side_image       = $request->file('side_image');
            $extension = $side_image->getClientOriginalExtension();
            $filename = 'side_image_' . time() . '.' .  $extension;
            $image_resize = Image::make($side_image->getRealPath());
            $image_resize->save($this->securityPath . $filename);
            $validated['side_image'] = $filename;
        }
        $securityCheck=$this->securityCheckRepository->createSecurityCheck($validated);
        if($securityCheck->status()==200){
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
        $securityCheck = $this->securityCheckRepository->getSecurityCheckById($id);
        return inertia::render('admin/security-check/show', compact('securityCheck'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $securityCheck = $this->securityCheckRepository->getSecurityCheckById($id);
        $suppliers = $this->supplierRepository->getSuppliers();
        $vehicles = $this->vehicleRepository->getVehicles();
        return inertia::render('admin/security-check/edit', compact('securityCheck', 'suppliers', 'vehicles'));
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

        $securityCheck=$this->securityCheckRepository->updateSecurityCheck($validated,$id);
        if ($securityCheck->status()==200){
            return redirect()->route('security-check.index')->with('success', 'Security Check updated successfully');
        }else{
            return redirect()->back()->with('status', 'Security Check could not be updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $securityCheck = $this->securityCheckRepository->deleteSecurityCheck($id);
        if ($securityCheck->status() == 200) {
            return redirect()->route('security-check.index')->with('success', 'Security Check deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Security Check could not be deleted');
        }
    }
}
