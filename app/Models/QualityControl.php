<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualityControl extends Model
{
    use HasFactory;

    protected $fillable = [
        'qc_code', 'weighbridge_id', 'created_by', 'visual_inspection', 'visual_inspection_comment', 'visual_inspection_image', 'moisture_content', 'aflatoxin_content'
    ];

    public function weighbridge()
    {
        return $this->belongsTo(Weighbridge::class, 'weighbridge_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function warehouse()
    {
        return $this->hasOne(Warehouse::class, 'quality_control_id');
    }

    protected static function booted(): void
    {
        parent::booted();

        self::creating(static function (QualityControl $qualityControl) {
            $old_qualityControl = QualityControl::latest()->first();
            if ($old_qualityControl) {
                $old_code = explode('-', $old_qualityControl->qc_code)[1];
                $new_code = str_pad((int)$old_code + 1, 3, '0', STR_PAD_LEFT);
                $qualityControl->qc_code = 'EFQC-' . $new_code;
            } else {
                $qualityControl->qc_code = 'EFQC-001';
            }
        });
    }
}
