<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Appliances;
use App\Models\AppliancesWorkingStocks;

class StocksController extends Controller
{    
    public function AppliancesWorkingStocks(){
        $appliancesWorkingStocks = AppliancesWorkingStocks::where('status', 0)->latest()->get();
        //dd($appliancesWorkingStocks);
        return view('backend.stocks.appliancesWorkingStocks_all', compact('appliancesWorkingStocks'));
    }
}
