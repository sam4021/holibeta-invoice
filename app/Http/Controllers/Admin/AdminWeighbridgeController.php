<?php

namespace App\Http\Controllers\Admin;


use File;
use App\Http\Controllers\Controller;
use App\Interfaces\SecurityCheckInterface;
use App\Interfaces\WeighbridgeInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;

class AdminWeighbridgeController extends Controller
{
    private $deliveryRepository;
    private $weighbridgeRepository;
    private $weighbridgePath;
    public function __construct(SecurityCheckInterface $deliveryRepository, WeighbridgeInterface $weighbridgeRepository)
    {
        $this->deliveryRepository = $deliveryRepository;
        $this->weighbridgeRepository = $weighbridgeRepository;
        $this->weighbridgePath = public_path() . '/images/weighbridge/';
        File::isDirectory($this->weighbridgePath) or File::makeDirectory($this->weighbridgePath, 0777, true, true);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $weighbridges=$this->weighbridgeRepository->getWeighbridges();
        $filters=request()->all('search','showing','shift','machine');
        $deliveries = $this->deliveryRepository->getEmptySecurityChecks();
        return inertia::render('admin/weighbridge/index', compact(
            'weighbridges',
            'filters',
            'deliveries'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $deliveries= $this->deliveryRepository->getSecurityChecks();
        return inertia::render('admin/weighbridge/create',compact('deliveries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated=$request->validate([
            'delivery'=>'required|integer|exists:security_checks,id', 
            'weight'=>'required',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg',
        ]);
        if ($request->hasFile('image')) {
            $image       = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $filename = 'image_' . time() . '.' .  $extension;
            $image_resize = Image::make($image->getRealPath());
            $image_resize->save($this->weighbridgePath . $filename);
            $validated['image'] = $filename;
        }
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
        $deliveries = $this->deliveryRepository->getSecurityChecks();
        return inertia::render('admin/weighbridge/edit', compact('weighbridge', 'deliveries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated=$request->validate([
            'delivery' => 'required|integer|exists:security_checks,id',
            'weight' => 'required',
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
