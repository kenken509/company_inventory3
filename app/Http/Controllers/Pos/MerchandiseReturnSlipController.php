<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MerchadiseReturnSlip;

class MerchandiseReturnSlipController extends Controller
{
    public function MerchandiseReturnsAll(){
        $mrs = MerchadiseReturnSlip::latest()->get();
        
       
        //$mrs = MerchadiseReturnSlip::with('getDefectiveAppliances','getDefectiveFurniture')->latest()->get();
        //dd($mrs);
        return view('backend.merchandiseReturns.merchandiseReturns_all', compact('mrs'));
    }
}
