<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WarehouseBags extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'created_by', 'bag_code', 'warehouse_id', 'barcode_no','weight', 'grain_id'
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function grain()
    {
        return $this->belongsTo(Grains::class, 'grain_id');
    }

    protected static function booted(): void
    {
        parent::booted();

        self::creating(static function (WarehouseBags $warehouse) {
            $old_warehouse = WarehouseBags::latest()->first();
            if ($old_warehouse){
                $old_code = explode('-',$old_warehouse->bag_code)[1];
                $new_code = str_pad((int)$old_code+1, 3, '0', STR_PAD_LEFT);
                $warehouse->bag_code ='EFWHB-'.$new_code;
            }else{
                $warehouse->bag_code ='EFWHB-001';
            }
        });
    }
}
