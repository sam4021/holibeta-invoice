<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SecurityCheck extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'created_by', 'vehicle_reg_no', 'vehicle_type', 'front_image', 'back_image', 'side_image', 'top_image', 'driver_id', 'timeslot', 'security_check_code', 'county_id', 'subcounty_id', 'no_of_bags', 'vehicle_plate_front', 'vehicle_plate_back', 'village'
    ];


    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function weighbridge()
    {
        return $this->hasOne(Weighbridge::class, 'delivery_id');
    }

    public function grains()
    {
        if (isset($this->weighbridge->qualityControl->warehouse)) {
           if ($this->weighbridge->qualityControl->warehouse->grains()) {
                return $this->weighbridge->qualityControl->warehouse->grains();
           }
            return [];
        }
        return [];
    }

    public function county()
    {
        return $this->belongsTo(County::class, 'county_id');
    }

    public function subcounty()
    {
        return $this->belongsTo(Subcounty::class, 'subcounty_id');
    }

    protected static function booted(): void
    {
        parent::booted();

        self::creating(static function (SecurityCheck $securityCheck) {
            $old_securityCheck = SecurityCheck::latest()->first();
            if ($old_securityCheck) {
                $old_code = explode('-', $old_securityCheck->security_check_code)[1];
                $new_code = str_pad((int)$old_code + 1, 3, '0', STR_PAD_LEFT);
                $securityCheck->security_check_code = 'EFSC-' . $new_code;
            } else {
                $securityCheck->security_check_code = 'EFSC-001';
            }
        });
    }
}


