<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
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
            'firstname' => $this->firstname,
            'middlename' => $this->middlename,
            'lastname' => $this->lastname, 
            'name'=>$this->firstname.' '.$this->middlename.' '.$this->lastname,
            'created_by' => new UserResource($this->whenLoaded('createdBy')),  
            'id_no' => $this->id_no,
            'id_image_front' => $this->id_image_front,
            'id_image_back' => $this->id_image_back,
            'driver_image' => $this->driver_image,
            'slug' => $this->slug
        ];
    }
}
