<?php

namespace App\Http\Controllers\Admin;

use File;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Interfaces\DriverInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Enums\RoleEnum;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;

class AdminDriverController extends Controller
{
    private DriverInterface $driverRepository;
    private $driverPath;

    public function __construct(DriverInterface $driverRepository){
        $this->driverRepository= $driverRepository;
        $this->middleware(['role:'.RoleEnum::Admin->value]);
        $this->driverPath = public_path() . '/images/driver/';
        File::isDirectory($this->driverPath) or File::makeDirectory($this->driverPath, 0777, true, true);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drivers=$this->driverRepository->getDrivers();
        $filters = request()->all('search', 'showing');

        return inertia::render('admin/drivers/index', compact('drivers','filters'));
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
            'firstname'=>'required|string|max:20',
            'middlename'=>'nullable|string|max:20',
            'lastname'=>'required|string|max:20',
            'id_no'=>'required|string|max:125',
            'id_image_front'=> 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
            'id_image_back' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
            'driver_image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
        ]);
        $validated['created_by'] = Auth::user()->id;
        if ($request->hasFile('id_image_front')) {
            $id_image_front       = $request->file('id_image_front');
            $extension = $id_image_front->getClientOriginalExtension();
            $filename = 'id_image_front_' . time() .'.'.  $extension;
            $image_resize = Image::make($id_image_front->getRealPath());
            $image_resize->save($this->driverPath . $filename);
            $validated['id_image_front'] = $filename;
        }
        if ($request->hasFile('id_image_back')) {
            $id_image_back       = $request->file('id_image_back');
            $extension = $id_image_back->getClientOriginalExtension();
            $filename = 'id_image_back_' . time() . '.' .  $extension;
            $image_resize = Image::make($id_image_back->getRealPath());
            $image_resize->save($this->driverPath . $filename);
            $validated['id_image_back'] = $filename;
        }
        if ($request->hasFile('driver_image')) {
            $driver_image       = $request->file('driver_image');
            $extension = $driver_image->getClientOriginalExtension();
            $filename = 'driver_image_' . time() . '.' .  $extension;
            $image_resize = Image::make($driver_image->getRealPath());
            $image_resize->save($this->driverPath . $filename);
            $validated['driver_image'] = $filename;
        }
        $driver=$this->driverRepository->storeDriver($validated);

        if ($driver->status()==200) {
            return redirect()->back()->with('success', 'Driver created successfully');
        } else {
            return redirect()->back()->with('status', 'Driver creation failed');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $driver = $this->driverRepository->getDriverById($id);
        return inertia::render('admin/drivers/show', compact('driver'));
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
            'firstname'=>'required|string|max:20',
            'middlename'=>'nullable|string|max:20',
            'lastname'=>'required|string|max:20',
            'id_no'=>'required|string|max:125'
        ]);
        $driver=$this->driverRepository->updateDriver($validated,$id);
        if ($driver['status']==200) {
            return redirect()->back()->with('success', $driver['message']);
        } else {
            return redirect()->back()->with('status', $driver['message']);
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
