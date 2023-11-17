<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SecurityCheckResource extends JsonResource
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
            'supplier'=>new SupplierResource($this->whenLoaded('supplier')), 
            'created_by'=>new UserResource($this->whenLoaded('createdBy')), 
            'vehicle_reg_no'=>$this->vehicle_reg_no, 
            'vehicle'=>new VehicleResource($this->whenLoaded('vehicle')), 
            'grain'=>new GrainResource($this->grain),
            'driver'=>new DriverResource($this->driver),
            'timeslot'=>$this->timeslot,
            'front_image'=>$this->front_image, 
            'back_image'=>$this->back_image, 
            'side_image'=>$this->side_image,
            'top_image' => $this->top_image,
            'code'=>$this->security_check_code,
        ];
    }
}
