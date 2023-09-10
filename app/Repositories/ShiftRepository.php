<?php

namespace App\Repositories;

use App\Http\Resources\ShiftResource;
use App\Interfaces\ShiftInterface;
use App\Models\Shift;

class ShiftRepository implements ShiftInterface
{

    public function getShift(){
     $shifts=Shift::query()
         ->when(request('search'),function($query){
             $query->where('name','like','%'.request('search').'%');
         })
     ->paginate(request('showing')??10);
     return ShiftResource::collection($shifts);
    }

    public function createShift($data){
        try {
            $shift=Shift::create($data);
            return response()->json([
                'status'=>200,
                'message'=>'Shift created successfully',
                'shift'=>new ShiftResource($shift)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'=>400,
                'message'=>'Shift creation failed',
                'error'=>$th->getMessage()
            ]);
        }
    }

    public  function updateShift($data, $id){
        try {
            $shift=Shift::find($id);
            $shift->update($data);
            return response()->json([
                'status'=>200,
                'message'=>'Shift updated successfully',
                'shift'=>new ShiftResource($shift)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'=>400,
                'message'=>'Shift update failed',
                'error'=>$th->getMessage()
            ]);
        }
    }

    public function deleteShift($id){
        try {
            $shift=Shift::findOrFail($id);
            $shift->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Shift deleted successfully',
                'shift'=>new ShiftResource($shift)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'=>400,
                'message'=>'Shift deletion failed',
                'error'=>$th->getMessage()
            ]);
        }
    }
}
