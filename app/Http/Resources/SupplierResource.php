<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
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
            'name'=>$this->name,
            'slug'=>$this->slug,
            'created_by'=>$this->createdBy,
            'supplier_code'=>$this->supplier_code,
            'status'=>$this->status,
            'phone' => $this->phone,
            'email' => $this->email,
            'id_no' => $this->id_no,
            'age_limits' => $this->age_limits
        ];
    }
}
