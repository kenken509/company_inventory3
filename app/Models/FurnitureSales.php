<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FurnitureSales extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function getSupplier(){
        return $this->belongsTo(furnitureSuppliers::class, 'supplier_id', 'id');
    }

    public function getCategory(){
        return $this->belongsTo(FurnitureCategories::class, 'category_id', 'id');
    }

    public function getProduct(){
        return $this->belongsTo(furnitureProducts::class, 'product_model_id', 'id');
    }
}
