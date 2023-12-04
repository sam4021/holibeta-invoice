<?php

namespace App\Repositories;

use App\Enums\ConfirmStatusEnum;
use App\Http\Resources\QualityControlResource;
use App\Interfaces\QualityControlInterface;
use App\Models\QualityControl;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class QualityControlRepository implements QualityControlInterface
{

    public function getQualityControls(){
        $qualityControls= QualityControl::with(['weighbridge', 'createdBy'])
            ->paginate(request('showing')??10);

        return QualityControlResource::collection($qualityControls);
    }

    public function getAllQualityControls()
    {
        $qualityControls = QualityControl::with(['weighbridge', 'createdBy'])
        ->get();

        return QualityControlResource::collection($qualityControls);
    }

    public function getQualityControlById(string $id){
        return new QualityControlResource(QualityControl::with(['weighbridge', 'createdBy'])->findOrFail($id));
    }

    public function  createQualityControl($data){
        try {
            $qualityControl= QualityControl::create([
                'weighbridge_id' => $data['weighbridge'],
                'created_by' => $data['created_by'],
                'visual_inspection' => $data['visual_inspection'],
                'visual_inspection_comment' => $data['visual_inspection_comment'],
                'visual_inspection_image' => $data['visual_inspection_image'],
                'moisture_content' => $data['moisture_content'],
                'aflatoxin_content' => $data['aflatoxin_content']
            ]);
            return response()->json(['message'=> 'Quality Control created successfully', 'qualityControl'=> $qualityControl],200);
        }catch (\Exception $exception){
            dd($exception->getMessage());
            return response()->json(['message'=>$exception->getMessage()],400);
        }
    }

    public function updateQualityControl(array $data, string $id){
        try {
            $qualityControl= QualityControl::findOrFail($id);
            $qualityControl->update(
                [
                    'weighbridge_id' => $data['weighbridge'],
                    'created_by' => $data['created_by'],
                    'visual_inspection' => $data['visual_inspection'],
                    'visual_inspection_comment' => $data['visual_inspection_comment'],
                    // 'visual_inspection_image' => $data['visual_inspection_image'],
                    'moisture_content' => $data['moisture_content'],
                    'aflatoxin_content' => $data['aflatoxin_content']
                ]
            );
            return response()->json(['message'=> 'Quality Control updated successfully', 'qualityControl'=> $qualityControl],200);
        }catch (\Exception $exception){
dd($exception->getMessage());
            return response()->json(['message'=>$exception->getMessage()],400);
        }
    }

    public function deleteQualityControl(int $id)
    {

        try {
            $qualityControl= QualityControl::findOrFail($id);
            $qualityControl->delete();
            return response()->json(['message'=> 'Quality Control deleted'],200);
        }catch (\Exception $exception){
            return response()->json(['message'=>$exception->getMessage()],400);
        }
    }

}
