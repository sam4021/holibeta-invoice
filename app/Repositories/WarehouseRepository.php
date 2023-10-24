<?php

namespace App\Repositories;

use App\Http\Resources\WarehouseResource;
use App\Interfaces\WarehouseInterface;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class WarehouseRepository implements WarehouseInterface
{

    public function getWarehouses(){
        $warehouse= Warehouse::with(['supplier', 'createdBy'])
            ->paginate(request('showing')??10);

        return WarehouseResource::collection($warehouse);
    }

    public function getWarehouseById(string $id){
        return new WarehouseResource(Warehouse::with(['supplier', 'createdBy'])->findOrFail($id));
    }

    public function  createWarehouse($data){
        try {
            $warehouse= Warehouse::create([
                'supplier_id'=>$data['supplier'], 
                'created_by'=>$data['created_by'],
                'no_of_bags' => $data['no_of_bags'],
                'weight_per_bag' => $data['weight_per_bag'],
                'barcode_no' => $data['barcode_no']
            ]);
            return response()->json(['message'=> 'Warehouse Check created successfully', 'warehouse'=> $warehouse],200);
        }catch (\Exception $exception){
            return response()->json(['message'=>$exception->getMessage()],400);
        }
    }

    public function updateWarehouse(array $data, string $id){
        try {

            $warehouse= Warehouse::findOrFail($id);
            $warehouse->update(
                [
                    'supplier_id' => $data['supplier'],
                    'no_of_bags' => $data['no_of_bags'],
                    'weight_per_bag' => $data['weight_per_bag'],
                    'barcode_no' => $data['barcode_no']
                ]
            );
            return response()->json(['message'=> 'Warehouse updated successfully', 'warehouse'=> $warehouse],200);
        }catch (\Exception $exception){
            return response()->json(['message'=>$exception->getMessage()],400);
        }
    }

    public function deleteWarehouse(int $id)
    {

        try {
            $warehouse= Warehouse::findOrFail($id);
            $warehouse->delete();
            return response()->json(['message'=> 'Warehouse Check deleted'],200);
        }catch (\Exception $exception){
            return response()->json(['message'=>$exception->getMessage()],400);
        }
    }

}
