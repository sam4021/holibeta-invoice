<?php

namespace App\Repositories;

use App\Http\Resources\DriverResource;
use App\Interfaces\DriverInterface;
use App\Models\Driver;

class DriverRepository implements DriverInterface
{

    public function getDrivers(){
        $drivers= Driver::when(request('search'), function($query){
               $query->where('firstname','like','%'.request('search').'%');
           })
            ->orderBy('created_at', 'DESC')
            ->paginate(request('showing')??10);
        return DriverResource::collection($drivers);
    }

    public function getDriverById($id)
    {
        $driver = Driver::findBySlugOrFail($id);
        return new DriverResource($driver);
    }

    public function storeDriver($data){
        try {
            $driver= Driver::create([
                'firstname'=> $data['firstname'],
                'middlename'=> $data['middlename'],
                'lastname'=> $data['lastname'],
                'id_no'=> $data['id_no'],
                'id_image_front'=> $data['id_image_front'],
                'id_image_back' => $data['id_image_back'],
                'driver_image'=>$data['driver_image'],
                'created_by'=>$data['created_by']
            ]);
            return response()->json([
                'status'=>200,
                'message'=> 'Driver created successfully',
                'driver'=>new DriverResource($driver)
            ]);
        } catch (\Throwable $th) {
            dd($th);
            return response()->json([
                'status'=>400,
                'message'=> 'Driver creation failed',
                'error'=>$th->getMessage()
            ]);
        }
    }

    public function updateDriver($data, $id){
        try {
            $driver= Driver::find($id);
            $driver->update($data);
            return response()->json([
                'status'=>200,
                'message'=> 'Driver updated successfully',
                'driver'=>new DriverResource($driver)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'=>400,
                'message'=> 'Driver update failed',
                'error'=>$th->getMessage()
            ]);
        }
    }

    public function deleteDriver($id){
        try {
            $driver= Driver::findOrFail($id);
            $driver->delete();
            return response()->json([
                'status'=>200,
                'message'=> 'Driver deleted successfully',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'=>400,
                'message'=> 'Driver deletion failed',
                'error'=>$th->getMessage()
            ]);
        }
    }

    public function getDriversCount()
    {
        return number_format(Driver::count());
    }
}
