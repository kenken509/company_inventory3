<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppliancesWorkingStocks extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function scopeFilterByAvailable($query)
    {        
        $query->where('status', 0);
    }

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
        return $this->belongsTo(Serials::class,'serial_id','id');
    }//end of function

    public function getCategory(){
        return $this->belongsTo(AppliancesCategories::class,'category_id','id');
    }//end of function

    public function getDr(){
        return $this->belongsTo(AppliancesDeliveries::class,'dr_id','id');
    }
    public function getSi(){
        return $this->belongsTo(AppliancesSales::class,'si_id','id');
    }
}
