<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WarehouseResource extends JsonResource
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
            'qc'=>new QualityControlResource($this->whenLoaded('qualityControl')), 
            'created_by'=>new UserResource($this->createdBy),
            'no_of_bags' => $this->no_of_bags,
            'weight_per_bag' => $this->weight_per_bag,
            'barcode_no' => $this->barcode_no,
            'code' => $this->warehouse_code,
            'bags'=> WarehouseBagResource::collection($this->bags),
            'grains'=>$this->grains(),
        ];
    }
}