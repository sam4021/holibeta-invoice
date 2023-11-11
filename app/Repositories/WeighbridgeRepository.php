<?php

namespace App\Repositories;

use App\Enums\ConfirmStatusEnum;
use App\Http\Resources\WeighbridgeResource;
use App\Interfaces\WeighbridgeInterface;
use App\Models\Weighbridge;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class WeighbridgeRepository implements WeighbridgeInterface
{

    public function getWeighbridges(){
        $weighbridges= Weighbridge::with(['supplier', 'createdBy'])
            ->paginate(request('showing')??10);

        return WeighbridgeResource::collection($weighbridges);
    }

    public function getWeighbridgeById(string $id){
        return new WeighbridgeResource(Weighbridge::with(['supplier', 'createdBy'])->findOrFail($id));
    }

    public function  createWeighbridge($data){
        try {
            $weighbridge= Weighbridge::create([
                'supplier_id'=>$data['supplier'], 
                'created_by'=>$data['created_by'], 
                'weight'=>$data['weight'],
                'moisture_content'=>$data['moisture_content'],
                'visual_inspection'=>$data['visual_inspection'],
                'visual_inspection_comment'=>$data['visual_inspection_comment'],
                'visual_inspection_image'=>$data['visual_inspection_image']
            ]);
            return response()->json(['message'=> 'Weighbridge created successfully', 'weighbridge'=> $weighbridge],200);
        }catch (\Exception $exception){
            dd($exception->getMessage());
            return response()->json(['message'=>$exception->getMessage()],400);
        }
    }

    public function updateWeighbridge(array $data, string $id){
        try {
            $weighbridge= Weighbridge::findOrFail($id);
            $weighbridge->update(
                [
                    'supplier_id' => $data['supplier'],
                    'weight' => $data['weight'],
                    'moisture_content'=>$data['moisture_content'] 
                ]
            );
            return response()->json(['message'=> 'Weighbridge updated successfully', 'weighbridge'=> $weighbridge],200);
        }catch (\Exception $exception){
dd($exception->getMessage());
            return response()->json(['message'=>$exception->getMessage()],400);
        }
    }

    public function deleteWeighbridge(int $id)
    {

        try {
            $weighbridge= Weighbridge::findOrFail($id);
            $weighbridge->delete();
            return response()->json(['message'=> 'Weighbridge deleted'],200);
        }catch (\Exception $exception){
            return response()->json(['message'=>$exception->getMessage()],400);
        }
    }

}
