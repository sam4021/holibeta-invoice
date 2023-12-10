<?php

namespace App\Http\Resources;

use App\Models\Warehouse;
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
            'name' => $this->weighbridge_code,
            'delivery'=>new SecurityCheckResource($this->whenLoaded('delivery')), 
            'created_by'=>new UserResource($this->whenLoaded('createdBy')),
            'weight' => $this->weight,
            'image' => $this->image,
            // 'warehouse' => $this->warehouse?new WarehouseResource($this->warehouse):[] 
        ];
    }
}
