<?php

namespace App\Repositories;

use App\Http\Resources\WarehouseResource;
use App\Interfaces\WarehouseInterface;
use App\Models\Warehouse;
use App\Models\WarehouseBags;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class WarehouseRepository implements WarehouseInterface
{

    public function getWarehouses(){
        $warehouse= Warehouse::with(['createdBy', 'weighbridge'])
            ->paginate(request('showing')??10);

        return WarehouseResource::collection($warehouse);
    }

    public function getWarehouseById(string $id){
        return new WarehouseResource(Warehouse::with(['weighbridge', 'createdBy'])->findOrFail($id));
    }

    public function  createWarehouse($data){
        DB::beginTransaction();
        try {//dd($data['bags']);
            $warehouse= Warehouse::create([
                'weighbridge_id'=>$data['weighbridge'], 
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
                    'grain_id' => $bag['grain'],
                ]);
            }
            DB::commit();
            return response()->json(['message'=> 'Warehouse created successfully', 'warehouse'=> $warehouse],200);
        }catch (\Exception $exception){
            DB::rollBack();
            dd($exception);
            return response()->json(['message'=>$exception->getMessage()],400);
        }
    }

    public function updateWarehouse(array $data, string $id){
        try {

            $warehouse= Warehouse::findOrFail($id);
            $warehouse->update(
                [
                    'weighbridge_id' => $data['weighbridge'],
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
