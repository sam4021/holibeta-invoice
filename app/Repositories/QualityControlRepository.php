<?php

namespace App\Repositories;

use App\Enums\ConfirmStatusEnum;
use App\Http\Resources\QualityControlResource;
use App\Interfaces\QualityControlInterface;
use App\Models\QualityControl;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QualityControlRepository implements QualityControlInterface
{

    public function getQualityControls(){
        $qualityControls= QualityControl::with(['weighbridge', 'createdBy'])
            ->orderBy('created_at', 'DESC')
            ->paginate(request('showing')??10);

        return QualityControlResource::collection($qualityControls);
    }

    public function getAllQualityControls()
    {
        $qualityControls = QualityControl::with(['weighbridge', 'createdBy'])
            ->orderBy('created_at', 'DESC')
            ->get();

        return QualityControlResource::collection($qualityControls);
    }

    public function getEmptyQualityControls()
    {
        // $qualityControls = QualityControl::with(['weighbridge', 'createdBy'])
        //                     // ->doesntHave('warehouse')
        //                     ->where([['visual_inspection', 'Pass'],['aflatoxin_content', 'Pass']])
        //                     ->get();
        $qualityControls = DB::table('quality_controls')
                ->join('weighbridges', 'weighbridges.id', 'quality_controls.weighbridge_id')
                ->join('security_checks', 'security_checks.id', 'weighbridges.delivery_id')
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                    ->from('warehouses')
                        ->whereRaw('quality_controls.id = warehouses.quality_control_id')
                        ->whereNull('warehouses.deleted_at');
                })
                ->where('visual_inspection', '=', 'Pass')
                ->where('aflatoxin_content', '=', 'Pass')
                ->where('moisture_content', '<=', '13.5')
                ->select('quality_controls.id', DB::raw('CONCAT(security_checks.vehicle_reg_no, " :: " , security_checks.security_check_code) AS name'))
                ->get();
        
        return $qualityControls;
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
                    // 'weighbridge_id' => $data['weighbridge'],
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
