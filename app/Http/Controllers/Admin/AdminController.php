<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Enums\RoleEnum;
use App\Interfaces\DriverInterface;
use App\Interfaces\SupplierInterface;

class AdminController extends Controller
{
    private DriverInterface $driverRepository;
    private $supplierRepository;
    public function __construct(DriverInterface $driverRepository, SupplierInterface $supplierRepository)
    {
        // $this->middleware(['role:'.RoleEnum::Admin->value]);
        $this->driverRepository = $driverRepository;
        $this->supplierRepository = $supplierRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drivers = $this->driverRepository->getDriversCount();
        $suppliers = $this->supplierRepository->getSuppliersCount();
        return inertia::render('admin/index',compact('drivers', 'suppliers'));
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
