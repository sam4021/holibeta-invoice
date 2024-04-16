<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\TransactionTypeEnum;

class Transactions extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'reference',
        'transaction_no',
        'transaction_type',
        'narration',
        'customer_id',
        'created_by',
        'order_id'
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function lineItems()
    {
        return $this->hasMany(TransactionLineItems::class,'transaction_id');
    }

    public function totalAmount()
    {
        $total = 0.00;
        foreach ($this->lineItems as $key => $value) {
            $total = $total + $value->amount;
        }
        
        return $total;
    }

    public function status()
    {
        return $this->hasMany(TransactionStatus::class,'transaction_id');
    }
    
    public function latestStatus()
    {
        return $this->hasOne(TransactionStatus::class, 'transaction_id')->latest();
    }

    public function orders()
    {
        return $this->belongsTo(Order::class,'order_id');
    }

    protected static function booted(): void
    {
        parent::booted();

        self::creating(static function (Transactions $transaction) {
            $old_transaction = Transactions::where('transaction_type',$transaction->transaction_type)->latest()->first();

            if (TransactionTypeEnum::Invoice->value ==$transaction->transaction_type) {
                if ($old_transaction) {
                    $old_code = explode('-', $old_transaction->transaction_no)[1];
                    $new_code = str_pad((int)$old_code + 1, 3, '0', STR_PAD_LEFT);
                    $transaction->transaction_no = 'MCI-' . $new_code;
                } else {
                    $transaction->transaction_no = 'MCI-001';
                }
            }
            
            
            
        });
    }
}
