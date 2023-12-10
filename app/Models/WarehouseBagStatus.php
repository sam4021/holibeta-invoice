<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseBagStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_bag_id', 'created_by', 'status'
    ];
}
