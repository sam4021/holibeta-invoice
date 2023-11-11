<?php

namespace App\Repositories;

use App\Http\Resources\SupplierResource;
use App\Interfaces\SupplierInterface;
use App\Models\Suppliers;
use Illuminate\Support\Str;

class SupplierRepository implements SupplierInterface
{

    public function getSuppliers(){
        $suppliers= Suppliers::query()
            ->when(request('search'),function ($query){
                $query->where('firstname','like','%'.request('search').'%');
            })
            ->paginate(request('showing')??10);

        return SupplierResource::collection($suppliers);
    }

    public function supplierById(string $id){
        return new SupplierResource(Suppliers::findOrFail($id));
    }
    public function supplierBySlug(string $slug){
        return new SupplierResource(Suppliers::where('slug',$slug)->firstOrFail());
    }

    public function createSupplier(array $data){
        try {
            $supplierCode = Str::upper(Str::random(6));
            $supplier= Suppliers::create([
                'firstname' => $data['firstname'],
                'middlename' => $data['middlename'],
                'lastname' => $data['lastname'],
                'created_by' => $data['created_by'],
                'supplier_code' => $supplierCode,
                'phone' => $data['phone'],
                'email' => $data['email'],
                'id_no' => $data['id_no'],
                'county' => $data['county'],
                'subcounty' => $data['subcounty'],
                'ward' => $data['ward']
            ]);
            return response()->json(['message'=> 'Supplier created successfully', 'supplier'=> $supplier],200);
        }catch (\Exception $exception){
            dd($exception->getMessage());
            return response()->json(['message'=>$exception->getMessage()],400);
        }
    }

    public function updateSupplier(array $data, string $id){
        try {

            $supplier= Suppliers::findOrFail($id);
            $supplier->update(
                [
                    'firstname' => $data['firstname'],
                    'middlename' => $data['middlename'],
                    'lastname' => $data['lastname'],
                    'phone' => $data['phone'],
                    'email' => $data['email'],
                    'id_no' => $data['id_no'],
                    'county' => $data['county'],
                    'subcounty' => $data['subcounty'],
                    'ward' => $data['ward']
                ]
            );
            return response()->json(['message'=> 'Supplier updated successfully', 'supplier'=> $supplier],200);
        }catch (\Exception $exception){
            dd($exception->getMessage());
            return response()->json(['message'=>$exception->getMessage()],400);
        }
    }

    public function deleteSupplier($id){
        $supplier= Suppliers::findOrFail($id);
        $supplier->delete();
        return response()->json(['message'=> 'Supplier deleted successfully'],200);
    }
}
