<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppliancesDefectives extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getProduct(){
        return $this->belongsTo(Appliances::class,'product_model_id', 'id');
    }

    public function getSupplier(){
        return $this->belongsTo(Supplier::class,'supplier_id','id'); // belongsTo(RelatedModel::class,'your_field','field on related model')
    }

    public function getCategory(){
        return $this->belongsTo(AppliancesCategories::class,'category_id','id');
    }

    public function getBrand(){
        return $this->belongsTo(Brands::class,'brand_id','id');
    }

    public function getSerial(){
        return $this->belongsTo(Serials::class,'serial_id', 'id');
    }

    


}
