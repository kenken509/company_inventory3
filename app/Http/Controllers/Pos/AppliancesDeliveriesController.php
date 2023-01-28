<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AppliancesDeliveries;
use App\Models\AppliancesDefectives;
use App\Models\Supplier;
use App\Models\Categories;
use App\Models\Brands;
use App\Models\Products;
use App\Models\Appliances;
use App\Models\ProductsCap;
use App\Models\AppliancesCategories;
use App\Models\Serials;
use App\Models\AppliancesWorkingStocks;
use Auth;
use Illuminate\Support\Carbon;

class AppliancesDeliveriesController extends Controller
{        
    public function AppliancesDeliveriesAll(){
        $appliancesDeliveries = AppliancesDeliveries::latest()->get();
        
                
   
        return view('backend.appliancesDeliveries.AppliancesDeliveries_all', compact('appliancesDeliveries'));
    }// end of function

    public function AppliancesDeliveriesAdd(){

        //$brands         = Brands::all();
        $supplier       = Supplier::all();        
        $categories     = AppliancesCategories::all();
        //$products     = Products::all();
        $appliancesProducts    = Appliances::all();
      

        return view('backend.appliancesDeliveries.appliancesDeliveries_add', compact('supplier','categories','appliancesProducts'));
    }// end of function

    public function AppliancesDeliveriesStore(Request $request){

        DB::beginTransaction();
        try{
            if($request->category_id == null){
                $notification = array(
                    'message' => 'No data added', 
                    'alert-type' => 'error'
                );
    
                return redirect()->back()->with($notification);
            }else{
                $count_category = count($request->category_id); // counts the instance of rows in table                                           
                
                
                for($i = 0; $i < $count_category; $i++){ 
                    
                    $ExsistingSerial = Serials::where('name',$request->serial[$i])->exists();                 
                    if($ExsistingSerial > 0){
                        //$exist = true;
                        $notification = array(
                            'message' => 'Failed to Save, Duplicate Serial Number Detected!', 
                            'alert-type' => 'error'
                        );
                        return redirect()->back()->with($notification);
                    }                        

                    //check if unit is defective
                    if($request->status1[$i]==1){
                        //dd($request->reference[$i]);
                        $serialNumber   = Serials::insert([
                            'name' => $request->serial[$i],
                            'product_id' => $request->product_model_id[$i],
                            'created_by' => Auth::user()->id,
                            'created_at' => Carbon::now(),
                        ]);
                        
                        $serial_id = Serials::orderBy('id','DESC')->first();

                        $defective = new AppliancesDefectives();

                        $defective->product_model_id = $request->product_model_id[$i];
                        $defective->supplier_id = $request->supplier_id[$i];
                        $defective->brand_id  = $request->brand_id[$i];
                        $defective->serial_id = $serial_id->id;
                        $defective->category_id = $request->category_id[$i];
                        $defective->dr_id = $request->reference[$i];
                        $defective->qty = $request->qty[$i];
                        $defective->unit_cost = $request->unit_cost[$i];
                        $defective->date_in = $request->date[$i];
                        $defective->remarks = $request->remarks[$i];
                        $defective->created_by = Auth::user()->id;
                        $defective->created_at = Carbon::now();
                        $defective->save();


                    }else{
                        $serialNumber   = Serials::insert([
                            'name' => $request->serial[$i],
                            'product_id' => $request->product_model_id[$i],
                            'created_by' => Auth::user()->id,
                            'created_at' => Carbon::now(),
                        ]);
    
                        $serial_id = Serials::orderBy('id','DESC')->first();
                        
                        
                       
                        
                        $deliveries = new AppliancesDeliveries();
                        $deliveries->date_in            = $request->date[$i];
                        $deliveries->reference          = $request->reference[$i];
                        $deliveries->supplier_id        = $request->supplier_id[$i];
                        $deliveries->brand_id           = $request->brand_id[$i];
                        $deliveries->category_id        = $request->category_id[$i];                    
                        $deliveries->product_model_id   = $request->product_model_id[$i];
                        $deliveries->serial_number      = $serial_id->id;
                        $deliveries->qty                = $request->qty[$i];
                        $deliveries->unit_cost          = $request->unit_cost[$i];
                        $deliveries->srp                = $request->srp[$i];
                        $deliveries->remarks            = $request->remarks[$i];
                        //$deliveries->buying_price   = $request->buying_price[$i];
                        $deliveries->created_by         = Auth::user()->id;
                        $deliveries->status             = $request->status1[$i];
                        $deliveries->save();
    
                        //get latest dr record
                        $dr_id = AppliancesDeliveries::orderBy('id','DESC')->first();
                        
                        
                        $newAppliancesStock                     = new AppliancesWorkingStocks();
                        $newAppliancesStock->date_in            = $request->date[$i];
                        $newAppliancesStock->dr_id              = $dr_id->id;
                        $newAppliancesStock->supplier_id        = $request->supplier_id[$i];
                        $newAppliancesStock->brand_id           = $request->brand_id[$i];
                        $newAppliancesStock->category_id        = $request->category_id[$i];
                        $newAppliancesStock->product_model_id   = $request->product_model_id[$i];
                        $newAppliancesStock->serial_id          = $serial_id->id;
                        $newAppliancesStock->qty                = $request->qty[$i];
                        $newAppliancesStock->unit_cost          = $request->unit_cost[$i];
                        $newAppliancesStock->srp                = $request->srp[$i];
                        $newAppliancesStock->remarks            = $request->remarks[$i];
                        $newAppliancesStock->status             = $request->status1[$i];
                        $newAppliancesStock->created_by         = Auth::user()->id;
                        $newAppliancesStock->created_at         = Carbon::now();
                        $newAppliancesStock->save();
                    }// end else defective                                                                              
                } //end for loop                                                  
            }// end else
        }catch(\Exception $e){
            DB::rollback();
            dd($e);
            // $notification = array(
            //     'message' => 'Something Went Wrong!', 
            //     'alert-type' => 'error'
            // );

            // return redirect()->back()->with($notification);
        }
            
        
        DB::commit();
        $notification = array(
            'message' => 'Data saved successfully', 
            'alert-type' => 'success'
        );
        return redirect()->route('appliancesDeliveries.all')->with($notification);          
    }//end of function
//************************************************************** */
    public function AppliancesDeliveriesDelete($id){
        //algo
        //check if the delivered item is not sold.
        //if sold return back with notification. else perform deletion       
        //delete the related working stocks **checked
        //delete the related serial
        //delete the delivery
        
        $deliveryToDeleteCheck  = AppliancesWorkingStocks::where('dr_id',$id)->first();
        
        if($deliveryToDeleteCheck->si_id){
            $notification = array(
                'message' => 'Failed to Delete, Sold Item!', 
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }else{
            DB::beginTransaction();

            try {
                $deliveryToDelete  = AppliancesDeliveries::findOrFail($id);
            
                $serial_id = $deliveryToDelete->serial_number;
            
                $workingAppliancesToDelete = AppliancesWorkingStocks::where([            
                    ['serial_id', '=', $deliveryToDelete->serial_number],        
                    ['dr_id', '=', $deliveryToDelete->id],                    
                ])->delete();

                $deliveryToDelete->delete();
                $serialToDelete = Serials::where('id', $serial_id )->delete();
                
                DB::commit();
                // all good
            } catch (\Exception $e) {
                DB::rollback();
                $notification = array(
                    'message' => 'Failed to Delete, Something Went Wrong!', 
                    'alert-type' => 'error',
                );
                return back()->with($notification);
            }// end try catch
                                            
            $notification = array(
                'message' => 'Data Deleted successfully', 
                'alert-type' => 'success'
            );
            return redirect()->route('appliancesDeliveries.all')->with($notification);
           
        }// end else
        

    }// end of function
    
}