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

    public function qualityControl()
    {
        return $this->warehouse->qualityControl();
    }

    public function weighbridge()
    {
        return $this->warehouse->qualityControl->weighbridge();
    }
    
    public function delivery()
    {
        return $this->weighbridge->delivery();
    }

    public function supplier()
    {
        return $this->delivery->supplier();
    }

    public function driver()
    {
        return $this->delivery->driver();
    }

    public function status()
    {
        return $this->hasMany(WarehouseBagStatus::class, 'warehouse_bag_id');
    }

    public function latestStatus()
    {
        return $this->hasOne(WarehouseBagStatus::class, 'warehouse_bag_id')->latest();
    }

    public function currentStatus()
    {
        $status = $this->join('warehouse_bag_statuses', 'warehouse_bags.id', 'warehouse_bag_statuses.warehouse_bag_id')
        ->where('warehouse_bags.id', '=', $this->id)
            ->orderBy('warehouse_bag_statuses.id', 'desc')
            ->first()->status;

        return $status;
    }

    protected static function booted(): void
    {
        parent::booted();

        self::creating(static function (WarehouseBags $warehouse) {
            $old_warehouse = WarehouseBags::orderByDesc('id')->limit(1)->get();
            if (count($old_warehouse)){
                $old_code = explode('-', $old_warehouse[0]->bag_code)[1];
                $new_code = str_pad((int)$old_code+1, 3, '0', STR_PAD_LEFT);
                $warehouse->bag_code ='EFWHB-'.$new_code;
            }else{
                $warehouse->bag_code ='EFWHB-001';
            }
        });
    }
}
