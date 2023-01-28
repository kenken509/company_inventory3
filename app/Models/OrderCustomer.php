<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCustomer extends Model
{
    use HasFactory;

    public function getProduct(){
        return $this->belongsTo(Appliances::class,'product_id', 'id');
    }

    public function order(){
        return $this->belongsTo(Orders::class,'order_id', 'id');
    }
}
