<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\furnitureProducts;

class FurnitureWorkingStocksController extends Controller
{
    public function FurnituresWorkingStocksAll(){
        $furnitures = furnitureProducts::where('qty','>','0')->latest()->get();

        return view('backend.stocks.furnitureWorkingStocks_all', compact('furnitures'));
    }
}
