<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\FurnitureDefectives;
use App\Models\MerchadiseReturnSlip;
use Auth;
use Illuminate\Support\Carbon;

class FurnitureDefectivesController extends Controller
{
    public function FurnitureDefectivesAll(){
        $defectiveFurnitures  = FurnitureDefectives::where('status', 1)->latest()->get(); //where('status', 1)->latest()->get();
        
        return view('backend.furnitureDefectives.furnitureDefectives_all', compact('defectiveFurnitures'));
    }//end method

    public function FurnitureDefectivesReturn($id){
        
        $unitToReturn = FurnitureDefectives::findOrFail($id)->first();

        DB::beginTransaction();
        try{
            
            $mrs = new MerchadiseReturnSlip();

            $mrs->furniture_defective_id = $unitToReturn->id;
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
            dd($e);
            $notification = array(
                'message' => 'Failed to Return, Something Went Wrong!', 
                'alert-type' => 'error',
            );
            return back()->with($notification);
        }


        DB::commit();
        $notification = array(
            'message' => 'Defective unit returnd successfully', 
            'alert-type' => 'success'
        );
        return redirect()->route('furnitureDefectives.all')->with($notification);                
    }//end method
}
