<?php

namespace App\Http\Resources\Transaction;

use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'amount' => $this->totalAmount(),
            'transaction_no' => $this->transaction_no,
            'transaction_type' => $this->transaction_type,
            'created_by' => $this->createdBy,
            'customer' => $this->customer,
            'status' => $this->status,
            'current_status' => $this->latestStatus,
            'order' => new OrderResource($this->orders),
            'created_at'=> date("j M, y g:i a", strtotime($this->created_at)),
        ];
    }
}
