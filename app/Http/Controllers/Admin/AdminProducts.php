<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\ProductWeight;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminProducts extends Controller
{
    private $productRepository;
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository=$productRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $products=$this->productRepository->getProducts();
        $filters=request()->all('search','showing','product_type','product_weight');
        $product_types=ProductType::select('id','name')->get();
        $product_weights=ProductWeight::all();
        return inertia::render('admin/products/index', compact('products','filters','product_weights','product_types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $product_types=ProductType::select('id','name')->get();
        $product_weights=ProductWeight::all();

        return inertia::render('admin/products/create',compact('product_types','product_weights'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated=$request->validate([
           'name'=>'required|string|max:125',
            'description'=>'nullable|string',
            'product_type'=>'required|integer|exists:product_types,id',
            'product_weight'=>'required|integer|exists:product_weights,id',
            'user_id'=>'required|integer|exists:users,id',
        ]);
        $product=$this->productRepository->createProduct($validated);
        if ($product->status()==200){
            return redirect()->route('products.index')->with('success','Product created successfully');
        }else{
            return redirect()->back()->with('status','Product could not be created');
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
        $product=$this->productRepository->deleteProduct($id);
        if ($product->status()==200){
            return redirect()->route('products.index')->with('success','Product deleted successfully');
        }else{
            return redirect()->back()->with('error','Product could not be deleted');
        }
    }
}
