<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'weighbridge_id', 'created_by', 'no_of_bags', 'weight_per_bag', 'barcode_no','warehouse_code','moisture_content'
    ];

    public function weighbridge()
    {
        return $this->belongsTo(Weighbridge::class, 'weighbridge_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function bags()
    {
        return $this->hasMany(WarehouseBags::class,'warehouse_id');
    }

    protected static function booted(): void
    {
        parent::booted();

        self::creating(static function (Warehouse $warehouse) {
            $old_warehouse = Warehouse::latest()->first();
            if ($old_warehouse){
                $old_code = explode('-',$old_warehouse->warehouse_code)[1];
                $new_code = str_pad((int)$old_code+1, 3, '0', STR_PAD_LEFT);
                $warehouse->warehouse_code ='EFWH-'.$new_code;
            }else{
                $warehouse->warehouse_code ='EFWH-001';
            }
        });
    }
}
