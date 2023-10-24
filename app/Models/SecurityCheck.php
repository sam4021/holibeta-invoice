<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SecurityCheck extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'supplier_id', 'created_by', 'vehicle_reg_no', 'vehicle_id', 'front_image', 'back_image', 'side_image'
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
}
