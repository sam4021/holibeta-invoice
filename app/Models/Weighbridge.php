<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Weighbridge extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'supplier_id', 'created_by', 'weight'
    ];
}
