<?php

namespace App\Repositories;

use App\Http\Resources\GrainResource;
use App\Interfaces\GrainInterface;
use App\Models\Grains;

class GrainRepository implements GrainInterface
{

    public function getGrains(){
        $grains= Grains::when(request('search'), function($query){
               $query->where('name','like','%'.request('search').'%');
           })
         ->paginate(request('showing')??10);
        return GrainResource::collection($grains);
    }

    public function storeGrain($data){
        try {
            $grain= Grains::create([
                'name'=> $data['name'],
                'created_by'=>$data['created_by']
            ]);
            return response()->json([
                'status'=>200,
                'message'=> 'Grain created successfully',
                'grain'=>new GrainResource($grain)
            ]);
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return response()->json([
                'status'=>400,
                'message'=> 'Grain creation failed',
                'error'=>$th->getMessage()
            ]);
        }
    }

    public function updateGrain($data, $id){
        try {
            $grain= Grains::find($id);
            $grain->update($data);
            return response()->json([
                'status'=>200,
                'message'=> 'Grain updated successfully',
                'grain'=>new GrainResource($grain)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'=>400,
                'message'=> 'Grain update failed',
                'error'=>$th->getMessage()
            ]);
        }
    }

    public function deleteGrain($id){
        try {
            $grain= Grains::findOrFail($id);
            $grain->delete();
            return response()->json([
                'status'=>200,
                'message'=> 'Grain deleted successfully',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'=>400,
                'message'=> 'Grain deletion failed',
                'error'=>$th->getMessage()
            ]);
        }
    }
}
