<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brands extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function getProducts(){
        return $this->hasMany(Appliances::class, 'brand_id','id');
    }

    public function getDeliveries(){
        return $this->hasMany(AppliancesDeliveries::class,'brand_id','id');
    }

}
