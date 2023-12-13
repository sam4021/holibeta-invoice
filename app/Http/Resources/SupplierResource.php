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
            'firstname'=>$this->firstname,
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
            'county' => new CountyResource($this->county),
            'subcounty' => new SubcountyResource($this->subcounty),
            'ward' => $this->ward,
            'bank_name' => $this->bank_name,
            'bank_account_name' => $this->bank_account_name,
            'bank_account_number' => $this->bank_account_number
        ];
    }
}
