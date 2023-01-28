<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppliancesSales extends Model
{
    use HasFactory;
    public function getProduct(){
        return $this->belongsTo(Appliances::class, 'product_model_id', 'id');
    }//end of function

    public function getSupplier(){
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }//end of function

    public function getBrand(){
        return $this->belongsTo(Brands::class,'brand_id','id');
    }//end of function

    public function getSerial(){
        return $this->belongsTo(Serials::class,'serial_number','id');
    }//end of function

    public function getCategory(){
        return $this->belongsTo(AppliancesCategories::class,'category_id','id');
    }//end of function
}
