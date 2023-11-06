<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SecurityCheck extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'supplier_id', 'created_by', 'vehicle_reg_no', 'vehicle_id', 'front_image', 'back_image', 'side_image','driver','timeslot','security_check_code'
    ];

    public function supplier()
    {
        return $this->belongsTo(Suppliers::class, 'supplier_id'); 
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by'); 
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id'); 
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver'); 
    }

    protected static function booted(): void
    {
        parent::booted();

        self::creating(static function (SecurityCheck $securityCheck) {
            $old_securityCheck = SecurityCheck::latest()->first();
            if ($old_securityCheck){
                $old_code = explode('-',$old_securityCheck->security_check_code)[1];
                $new_code = str_pad((int)$old_code+1, 3, '0', STR_PAD_LEFT);
                $securityCheck->security_check_code ='EFSC-'.$new_code;
            }else{
                $securityCheck->security_check_code ='EFSC-001';
            }
        });
    }
}
