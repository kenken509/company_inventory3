<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class furnitureSuppliers extends Model
{
    use HasFactory;

    protected $guarded =[];
    
    public function getProducts(){
        return $this->hasMany(furnitureProducts::class, 'supplier_id', 'id');
    }
}
