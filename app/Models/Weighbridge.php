<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Weighbridge extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'supplier_id', 'created_by', 'weight', 'moisture_content', 'visual_inspection', 'visual_inspection_comment', 'visual_inspection_image', 'weighbridge_code'
    ];

    public function supplier()
    {
        return $this->belongsTo(Suppliers::class, 'supplier_id');
    }    

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    protected static function booted(): void
    {
        parent::booted();

        self::creating(static function (Weighbridge $weighbridge) {
            $old_weighbridge = Weighbridge::latest()->first();
            if ($old_weighbridge) {
                $old_code = explode('-', $old_weighbridge->weighbridge_code)[1];
                $new_code = str_pad((int)$old_code + 1, 3, '0', STR_PAD_LEFT);
                $weighbridge->weighbridge_code = 'EFWB-' . $new_code;
            } else {
                $weighbridge->weighbridge_code = 'EFWB-001';
            }
        });
    }
}
