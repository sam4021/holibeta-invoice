<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Weighbridge extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'supplier_id', 'created_by', 'weight', 'moisture_content', 'visual_inspection', 'visual_inspection_comment', 'visual_inspection_image'
    ];

    public function supplier()
    {
        return $this->belongsTo(Suppliers::class, 'supplier_id');
    }    

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by'); 
    }
}
