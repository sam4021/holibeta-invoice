<?php

namespace App\Http\Resources;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WarehouseBagResource extends JsonResource
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
            'grain'=>new GrainResource($this->grain),
            'warehouse' => new WarehouseResource($this->whenLoaded('warehouse')), 
            'created_by'=>new UserResource($this->whenLoaded('createdBy')),
            'no_of_bags' => $this->no_of_bags,
            'weight' => $this->weight,
            'code' => $this->bag_code,
            'barcode_no'=> $this->barcode_no
        ];
    }
}