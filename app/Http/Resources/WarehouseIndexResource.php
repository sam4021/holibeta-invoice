<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WarehouseIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'qc' => $this->qualityControl,
            'created_by' => $this->createdBy,
            'no_of_bags' => $this->no_of_bags,
            'code' => $this->warehouse_code,
            'grains' => $this->grains(),
            'total_weight' => $this->total_weight,
            'supplier' => $this->supplier
        ];
    }
}
