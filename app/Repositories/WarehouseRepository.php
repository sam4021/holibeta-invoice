<?php

namespace App\Repositories;

use App\Http\Resources\WarehouseResource;
use App\Interfaces\WarehouseInterface;
use App\Models\Warehouse;
use App\Models\WarehouseBags;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class WarehouseRepository implements WarehouseInterface
{

    public function getWarehouses(){
        $warehouse= Warehouse::with(['createdBy','securityCheck'])
            ->paginate(request('showing')??10);

        return WarehouseResource::collection($warehouse);
    }

    public function getWarehouseById(string $id){
        return new WarehouseResource(Warehouse::with(['supplier', 'createdBy'])->findOrFail($id));
    }

    public function  createWarehouse($data){
        try {//dd($data);
            $warehouse= Warehouse::create([
                'security_check_id'=>$data['supplier'], 
                'created_by'=>$data['created_by'],
                'no_of_bags' => $data['no_of_bags'],
                'barcode_no' => Str::upper(Str::random(6)),
                'moisture_content'=>$data['moisture_content']
            ]);
            foreach ($data['bags'] as $bag) {
                WarehouseBags::create([
                    'warehouse_id'=>$warehouse->id, 
                    'weight'=>$bag['weight'],
                    'created_by'=>$data['created_by'],
                ]);
            }
            return response()->json(['message'=> 'Warehouse created successfully', 'warehouse'=> $warehouse],200);
        }catch (\Exception $exception){
            dd($exception);
            return response()->json(['message'=>$exception->getMessage()],400);
        }
    }

    public function updateWarehouse(array $data, string $id){
        try {

            $warehouse= Warehouse::findOrFail($id);
            $warehouse->update(
                [
                    'security_check_id' => $data['supplier'],
                    'no_of_bags' => $data['no_of_bags'],
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
