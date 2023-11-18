<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WeighbridgeResource extends JsonResource
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
            'code'=>$this->weighbridge_code,
            'supplier'=>new SupplierResource($this->whenLoaded('supplier')), 
            'created_by'=>new UserResource($this->whenLoaded('createdBy')),
            'weight' => $this->weight,
            'moisture_content' => $this->moisture_content,
            'visual_inspection' => $this->visual_inspection,
            'visual_inspection_comment' => $this->visual_inspection_comment, 
            'visual_inspection_image' => $this->visual_inspection_image
        ];
    }
}
