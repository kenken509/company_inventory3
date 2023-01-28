<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class furnitureProducts extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getCategories(){
        return $this->belongsTo(FurnitureCategories::class, 'category_id','id');
    }
    
    public function getSuppliers(){
        return $this->belongsTo(furnitureSuppliers::class, 'supplier_id', 'id');
    }

    public function getDr(){
        return $this->hasMany(furnituresDeliveries::class, 'product_model_id', 'id');
    }

    public function getSi(){
        return $this->hasMany(FurnitureSales::class, 'product_model_id', 'id' );
    }
}
