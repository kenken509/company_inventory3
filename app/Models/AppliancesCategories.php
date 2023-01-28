<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppliancesCategories extends Model
{
    use HasFactory;

    protected $guarded = []; // to avoid data breach. [] <- means all columns

    public function getProducts(){
        return $this->hasMany(Appliances::class, 'category_id', 'id');
    }
}
