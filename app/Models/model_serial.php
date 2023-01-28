<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class model_serial extends Model
{
    use HasFactory;
    protected $guarded = []; // to avoid data breach. [] <- means all columns
}
