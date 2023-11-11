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
            'firstname'=>$this->fisrtname,
            'middlename'=>$this->middlename,
            'lastname'=>$this->lastname,
            'name'=>$this->firstname.' '.$this->middlename.' '.$this->lastname,
            'slug'=>$this->slug,
            'created_by'=>$this->createdBy,
            'supplier_code'=>$this->supplier_code,
            'status'=>$this->status,
            'statusView'=>$this->status?'Active':'Disabled',
            'phone' => $this->phone,
            'email' => $this->email,
            'id_no' => $this->id_no,
            'county' => $this->county,
            'subcounty' => $this->subcounty,
            'ward' => $this->ward
        ];
    }
}
