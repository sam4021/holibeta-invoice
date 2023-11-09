<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Interfaces\GrainInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Enums\RoleEnum;
use Illuminate\Support\Facades\Auth;

class AdminGrainController extends Controller
{
    private GrainInterface $grainRepository;

    public function __construct(GrainInterface $grainRepository){
        $this->grainRepository= $grainRepository;
        $this->middleware(['role:'.RoleEnum::Admin->value]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grains=$this->grainRepository->getGrains();
        $filters = request()->all('search', 'showing');
        return inertia::render('admin/grains/index', compact('grains','filters'));
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
        $validated=$request->validate([
            'name'=>'required|string|max:125',
        ]);
        $validated['created_by'] = Auth::user()->id;
        $grain=$this->grainRepository->storeGrain($validated);

        if ($grain->status()==200) {
            return redirect()->back()->with('success', 'Grain created successfully');
        } else {
            return redirect()->back()->with('status', 'Grain creation failed');
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
        $validated=$request->validate([
            'name'=>'required|string|max:125',
            'status'=>'required|string',
        ]);
        $grain=$this->grainRepository->updateGrain($validated,$id);
        if ($grain['status']==200) {
            return redirect()->back()->with('success', $grain['message']);
        } else {
            return redirect()->back()->with('status', $grain['message']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $grain=$this->grainRepository->deleteGrain($id);
        if ($grain->status()==200) {
            return redirect()->back()->with('success', 'Grain deleted successfully');
        } else {
            return redirect()->back()->with('status', 'Grain deletion failed');
        }
    }
}
