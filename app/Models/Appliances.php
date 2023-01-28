<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appliances extends Model
{
    use HasFactory;
    protected $guarded = []; // to avoid data breach. [] <- means all columns
    
    public function supplier(){
        return $this->belongsTo(Supplier::class,'supplier_id','id'); // belongsTo(RelatedModel::class,'your_field','field on related model')
    }

    public function category(){
        return $this->belongsTo(AppliancesCategories::class,'category_id','id');
    }

    // public function brand(){
    //     return $this->belongsTo(Brands::class,'brand_id','id');
    // }
    
    public function getDeliveries(){
        return $this->belongsTo(AppliancesDeliveries::class,'id','product_model_id');
    }
    
    public function getSerials(){
        return $this->hasMany(Serials::class,'product_id','id');
    }

    public function getWorkingStock(){
        return $this->hasMany(AppliancesWorkingStocks::class,'product_model_id','id')->where('status',0);
    }

    public function getBrand(){
        return $this->belongsTo(Brands::class, 'brand_id','id');
    }
}

