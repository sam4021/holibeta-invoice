<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionVat extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'rate',
        'type',
        'created_by'
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    protected static function booted(): void
    {
        parent::booted();

        self::creating(static function (TransactionVat $vat) {
            $old_vat = TransactionVat::latest()->first();
            if ($old_vat) {
                $old_code = explode('-', $old_vat->code)[1];
                $new_code = str_pad((int)$old_code + 1, 3, '0', STR_PAD_LEFT);
                $vat->code = 'MCV-' . $new_code;
            } else {
                $vat->code = 'MCV-001';
            }
        });
    }
}
