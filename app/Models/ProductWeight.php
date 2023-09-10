<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductWeight extends Model
{
    use HasFactory;

    protected $fillable=['weight','measurement_unit','packaging_quantity','product_weight_id'];

    public function products(){
        return $this->hasMany(Product::class);
    }
}
