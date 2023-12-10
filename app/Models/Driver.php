<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Driver extends Model
{
    use HasFactory,SoftDeletes, Sluggable, SluggableScopeHelpers;

    protected $fillable = [
        'firstname','middlename','lastname', 'created_by',
        'id_no', 'id_image_front', 'id_image_back', 'driver_image'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['firstname','middlename','lastname']
            ],
        ];
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by'); 
    }
}
