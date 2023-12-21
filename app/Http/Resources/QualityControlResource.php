<?php

namespace App\Http\Resources;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QualityControlResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
            'code'=>$this->qc_code,
            'weighbridge'=>new WeighbridgeResource($this->whenLoaded('weighbridge')), 
            'created_by'=>new UserResource($this->createdBy),
            'visual_inspection'=>$this->visual_inspection,
            'visual_inspection_comment'=>$this->visual_inspection_comment,
            'visual_inspection_image'=>$this->visual_inspection_image, 
            'moisture_content'=>$this->moisture_content,
            'aflatoxin_content'=>$this->aflatoxin_content,
        ];
    }
}
