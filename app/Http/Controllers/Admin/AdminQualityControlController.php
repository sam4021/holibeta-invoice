<?php

namespace App\Http\Controllers\Admin;


use File;
use App\Http\Controllers\Controller;
use App\Interfaces\WeighbridgeInterface;
use App\Interfaces\QualityControlInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;

class AdminQualityControlController extends Controller
{
    private $qcRepository;
    private $weighbridgeRepository;
    private $qualityControlPath;
    public function __construct(QualityControlInterface $qcRepository, WeighbridgeInterface $weighbridgeRepository)
    {
        $this->qcRepository = $qcRepository;
        $this->weighbridgeRepository = $weighbridgeRepository;
        $this->qualityControlPath = public_path() . '/images/quality-control/';
        File::isDirectory($this->qualityControlPath) or File::makeDirectory($this->qualityControlPath, 0777, true, true);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $qcs=$this->qcRepository->getQualityControls();
        $filters=request()->all('search','showing','shift','machine');
        $weighbridges = $this->weighbridgeRepository->getAllWeighbridges();
        return inertia::render('admin/quality_control/index', compact(
            'weighbridges',
            'filters',
            'qcs'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $qc= $this->qcRepository->getQualityControls();
        return inertia::render('admin/quality_control/create',compact('deliveries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated=$request->validate([
            'weighbridge' =>'required|integer|exists:weighbridges,id',
            'visual_inspection' => 'required',
            'visual_inspection_comment' => 'required',
            'visual_inspection_image' => 'required|image|mimes:jpeg,jpg,png,gif,svg',
            'moisture_content' => 'required',
            'aflatoxin_content' => 'required'
        ]);
        if ($request->hasFile('visual_inspection_image')) {
            $image       = $request->file('visual_inspection_image');
            $extension = $image->getClientOriginalExtension();
            $filename = 'visual_inspection_image_' . time() . '.' .  $extension;
            $image_resize = Image::make($image->getRealPath());
            $image_resize->save($this->qualityControlPath . $filename);
            $validated['visual_inspection_image'] = $filename;
        }
        $validated['created_by'] = Auth::user()->id;
        $qc=$this->qcRepository->createQualityControl($validated);
        if($qc->status()==200){
            return redirect()->route('quality-control.index')->with('success', 'Quality Control added successfully');
        }else{
            return redirect()->back()->with('status', 'Error adding a Quality Control');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $qc = $this->qcRepository->getQualityControlById($id);
        return inertia::render('admin/quality_control/show', compact('qc'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $weighbridge = $this->weighbridgeRepository->getAllWeighbridges();
        $qc = $this->qcRepository->getQualityControls();
        return inertia::render('admin/quality_control/edit', compact('weighbridge', 'qc'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated=$request->validate([
            'weighbridge_id' => 'required|integer|exists:weighbridges,id',
            'visual_inspection' => 'required',
            'visual_inspection_comment' => 'required',
            // 'visual_inspection_image' => 'required|image|mimes:jpeg,jpg,png,gif,svg',
            'moisture_content' => 'required',
            'aflatoxin_content' => 'required'
        ]);

        $qc=$this->qcRepository->updateQualityControl($validated,$id);
        if ($qc->status()==200){
            return redirect()->route('quality-control.index')->with('success', 'Quality Control updated successfully');
        }else{
            return redirect()->back()->with('status', 'Quality Control could not be updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $qc = $this->qcRepository->deleteQualityControl($id);
        if ($qc->status() == 200) {
            return redirect()->route('quality-control.index')->with('success', 'Quality Control deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Quality Control could not be deleted');
        }
    }
}
