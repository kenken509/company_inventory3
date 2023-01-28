<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppliancesDefectives;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Carbon;
use App\Models\MerchadiseReturnSlip;
use App\Models\Serials;

class AppliancesDefectivesController extends Controller
{
    public function AppliancesDefectivesAll(){
        $defectiveAppliances = AppliancesDefectives::where('status', 1)->latest()->get();
        //dd($defectiveAppliances);
        return view('backend.appliancesDefectives.appliancesDefectives_all', compact('defectiveAppliances'));
    }// end method

    public function AppliancesDefectiveReturn($id){
        $unitToReturn = AppliancesDefectives::where('id', $id)->first();
        $serialToReturn = $unitToReturn->serial_id;        
        
        DB::beginTransaction();
        try{
            $mrs = new MerchadiseReturnSlip();

            $mrs->appliances_defective_id = $unitToReturn->id;
            $mrs->date_out = Carbon::now();
            $mrs->created_by = Auth::user()->id; 
            $mrs->save();
            
            $unitToReturn->update([
                'status' => '0',
                'updated_by' => Auth::user(),
                'updated_at' => Carbon::now(),
            ]);            
        }catch(\Exception $e){
            DB::rollback();
            //dd($e);
            
            $notification = array(
                'message' => 'Failed to Return, Something Went Wrong!', 
                'alert-type' => 'error',
            );
            return back()->with($notification);
        }

        DB::commit();
        $notification = array(
            'message' => 'Data saved successfully', 
            'alert-type' => 'success'
        );
        return redirect()->route('merchandiseReturns.all')->with($notification);       
    }// end method
}
