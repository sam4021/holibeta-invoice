<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\DeleteCustomersRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AdminCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Customer::class);

        $limit = request()->has('limit') ? request()->limit : 10;

        $customers = Customer::with('creator')
        ->whereCompany()
            ->applyFilters($request->all())
            ->select(
                'customers.*',
                DB::raw('sum(invoices.base_due_amount) as base_due_amount'),
                DB::raw('sum(invoices.due_amount) as due_amount'),
            )
            ->groupBy('customers.id')
            ->leftJoin('invoices', 'customers.id', '=', 'invoices.customer_id')
            ->paginateData($limit);

        return (CustomerResource::collection($customers))
            ->additional(['meta' => [
                'customer_total_count' => Customer::whereCompany()->count(),
            ]]);
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
