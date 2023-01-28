<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $guarded = []; // to avoid data breach. [] <- means all columns

    public function getProducts(){
        return $this->hasMany(Appliances::class, 'supplier_id', 'id');
    }
}
