<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable=[
        'name','code','dial_code','flag','currency_name','currency_code'
    ];

    public function users(){
        return $this->hasMany(User::class);
    }
}
