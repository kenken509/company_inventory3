<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItems extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getProduct(){
        return $this->belongsTo(Appliances::class,'product_id','id'); // belongsTo(RelatedModel::class,'your_field','field on related model')
    }
}
