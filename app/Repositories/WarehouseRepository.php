<?php

namespace App\Repositories;

use App\Http\Resources\WarehouseResource;
use App\Http\Resources\WarehouseBagResource;
use App\Interfaces\WarehouseInterface;
use App\Models\Warehouse;
use App\Models\WarehouseBags;
use App\Models\WarehouseBagStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Enums\StatusEnum;

class WarehouseRepository implements WarehouseInterface
{

    public function getWarehouses(){
        $warehouse= Warehouse::with(['createdBy', 'qualityControl'])
            ->paginate(request('showing')??10);

        return WarehouseResource::collection($warehouse);
    }

    public function getWarehouseById(string $id){
        return new WarehouseResource(Warehouse::with(['qualityControl', 'createdBy'])->findOrFail($id));
    }

    public function createWarehouse($data){
        DB::beginTransaction();
        try {//dd($data['bags']);
            $warehouse= Warehouse::create([
                'quality_control_id'=>$data['quality_control'], 
                'created_by'=>$data['created_by'],
                'no_of_bags' => $data['no_of_bags'],
                'barcode_no' => Str::upper(Str::random(6)),
            ]);
            foreach ($data['bags'] as $bag) {
                $bag = WarehouseBags::create([
                    'warehouse_id'=>$warehouse->id, 
                    'weight'=>$bag['weight'],
                    'created_by'=>$data['created_by'],
                    'grain_id' => 1,
                ]);
                $this->createStatus($bag->id,StatusEnum::InWarehouse->value,$data['created_by']);
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
                    'quality_control_id' => $data['quality_control'],
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

    public function getWarehouseBags()
    {
        $bags = DB::table('warehouse_bags')
            ->join('warehouses', 'warehouses.id', 'warehouse_bags.warehouse_id')
            ->join('grains', 'grains.id', 'warehouse_bags.grain_id')
            ->when(request('search'), function ($query) {
                $query->where('warehouse_bags.bag_code', 'like', '%' . request('search') . '%');
            })
            ->when(request('grain'), function ($query) {
                $query->where('warehouse_bags.grain_id', request('grain'));
            })
         ->select('warehouse_bags.id as bag_id', 'warehouse_bags.created_at as bag_date', 'warehouse_bags.bag_code', 'warehouse_bags.weight', 'warehouses.id as warehouse_id', 'warehouses.warehouse_code', 'grains.name as grain_name')
        ->paginate(request('showing') ?? 10)->withQueryString();
        return $bags;
    }

    public function getWarehouseBag(int $id)
    {
        return new WarehouseBagResource(WarehouseBags::with(['warehouse', 'createdBy'])->findOrFail($id));
    }

    public function createStatus(int $id, string $status, int $user)
    {
        WarehouseBagStatus::create([
            'warehouse_bag_id'=>$id,
            'created_by'=>$user,
            'status'=>$status
        ]);
    }

    public function getUniqueGrains()
    {
        $grains = DB::table('warehouse_bags')->select('grain_id')->distinct()->get()->toArray();
        $grainArr=[];
        foreach ($grains as $value) {
            array_push($grainArr,$value->grain_id);
        }
        $grains= DB::table('grains')->whereIn('id',$grainArr)->get();
        return $grains;
    }


    public function addWarehouseBags($id, $data)
    {
        DB::beginTransaction();
        try { //dd($data['bags']);
            $warehouse = Warehouse::findOrFail($id);
            $bags = $warehouse->no_of_bags + count($data['bags']);
            $warehouse->update(
                [
                    'no_of_bags' => $bags,
                ]
            );
            foreach ($data['bags'] as $bag) {
                $bag = WarehouseBags::create([
                    'warehouse_id' => $id,
                    'weight' => $bag['weight'],
                    'created_by' => $data['created_by'],
                    'grain_id' => 1,
                ]);
                $this->createStatus($bag->id, StatusEnum::InWarehouse->value, $data['created_by']);
            }
            DB::commit();
            return response()->json(['message' => 'Warehouse created successfully', 'warehouse' => $warehouse], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception);
            return response()->json(['message' => $exception->getMessage()], 400);
        }
    }
}
