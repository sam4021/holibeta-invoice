<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Suppliers extends Model
{
    use HasFactory,SoftDeletes, Sluggable, SluggableScopeHelpers;

    protected $fillable = [
        'name', 'created_by', 'supplier_code', 'status', 'phone', 'email', 'id_no', 'age_limits'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by'); 
    }
}
