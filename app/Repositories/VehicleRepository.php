<?php

namespace App\Repositories;

use App\Http\Resources\VehicleResource;
use App\Interfaces\VehicleInterface;
use App\Models\Vehicle;

class VehicleRepository implements VehicleInterface
{

    public function getVehicles(){
        $vehicles= Vehicle::when(request('search'), function($query){
               $query->where('name','like','%'.request('search').'%');
           })
         ->paginate(request('showing')??10);
        return VehicleResource::collection($vehicles);
    }

    public function storeVehicle($data){
        try {
            $vehicle= Vehicle::create([
                'name'=> $data['name'],
                'created_by'=>$data['created_by']
            ]);
            return response()->json([
                'status'=>200,
                'message'=> 'Vehicle created successfully',
                'vehicle'=>new VehicleResource($vehicle)
            ]);
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return response()->json([
                'status'=>400,
                'message'=> 'Vehicle creation failed',
                'error'=>$th->getMessage()
            ]);
        }
    }

    public function updateVehicle($data, $id){
        try {
            $vehicle= Vehicle::find($id);
            $vehicle->update($data);
            return response()->json([
                'status'=>200,
                'message'=> 'Vehicle updated successfully',
                'vehicle'=>new VehicleResource($vehicle)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'=>400,
                'message'=> 'Vehicle update failed',
                'error'=>$th->getMessage()
            ]);
        }
    }

    public function deleteVehicle($id){
        try {
            $vehicle= Vehicle::findOrFail($id);
            $vehicle->delete();
            return response()->json([
                'status'=>200,
                'message'=> 'Vehicle deleted successfully',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'=>400,
                'message'=> 'Vehicle deletion failed',
                'error'=>$th->getMessage()
            ]);
        }
    }
}
