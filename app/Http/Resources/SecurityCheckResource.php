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
            'created_by'=>new UserResource($this->whenLoaded('createdBy')), 
            'vehicle_reg_no'=>$this->vehicle_reg_no,
            'vehicle_type'=>$this->vehicle_type, 
            'driver'=>new DriverResource($this->driver),
            'timeslot'=>$this->timeslot,
            'front_image'=>$this->front_image, 
            'back_image'=>$this->back_image, 
            'side_image'=>$this->side_image,
            'top_image' => $this->top_image,
            'code'=>$this->security_check_code,
            'name'=>$this->security_check_code,
            'grains'=>$this->grains(),
            'county' => new CountyResource($this->county),
            'subcounty' => new SubcountyResource($this->subcounty),
            'name' => $this->vehicle_reg_no.' :: '. $this->security_check_code,
            'no_of_bags' => $this->no_of_bags,
            'vehicle_plate_front' => $this->vehicle_plate_front,
            'vehicle_plate_back' => $this->vehicle_plate_back,
        ];
    }
}
