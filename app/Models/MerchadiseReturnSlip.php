<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchadiseReturnSlip extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getDefectiveAppliances(){
        return $this->belongsTo(AppliancesDefectives::class, 'appliances_defective_id', 'id');
    }

    public function getDefectiveFurniture(){
        return $this->belongsTo(FurnitureDefectives::class, 'furniture_defective_id', 'id');
    }
    
}
