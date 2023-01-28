<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class furnituresDeliveries extends Model
{
    use HasFactory;
    protected $guarded = []; // to avoid data breach. [] <- means all columns

    public function getSupplier(){
        return $this->belongsTo(furnitureSuppliers::class,'supplier_id','id'); // belongsTo(RelatedModel::class,'your_field','field on related model')
    }
        
    public function getProduct(){
        return $this->belongsTo(furnitureProducts::class,'product_model_id','id');
    }
    
    public function getCategory(){
        return $this->belongsTo(FurnitureCategories::class,'category_id', 'id');
    }
}
