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
        'firstname','middlename','lastname', 'created_by', 'supplier_code', 'status', 'phone', 'email', 'id_no', 'county_id', 'subcounty_id', 'ward'
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

    public function county()
    {
        return $this->belongsTo(County::class, 'county_id');
    }

    public function subcounty()
    {
        return $this->belongsTo(Subcounty::class, 'subcounty_id');
    }

    protected static function booted(): void
    {
        parent::booted();

        self::creating(static function (Suppliers $supplier) {
            $old_supplier = Suppliers::latest()->first();
            if ($old_supplier) {
                $old_code = explode('-', $old_supplier->supplier_code)[1];
                $new_code = str_pad((int)$old_code + 1, 3, '0', STR_PAD_LEFT);
                $supplier->supplier_code = 'EFSU-' . $new_code;
            } else {
                $supplier->supplier_code = 'EFSU-001';
            }
        });
    }
}
