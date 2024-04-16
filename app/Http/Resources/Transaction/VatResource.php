<?php

namespace App\Http\Resources\Transaction;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VatResource extends JsonResource
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
            'created_by' => $this->createdBy,
            'created_at' => $this->created_at,
            'name' => $this->name,
            'type' => $this->type,
            'code' => $this->code,
            'rate' => number_format(floatval($this->rate), 2, '.', ','),
        ];
    }
}
