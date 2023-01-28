<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\AppliancesSales;
use App\Models\Categories;
use App\Models\Supplier;
use App\Models\Brands;
use App\Models\ProductsCap;
use App\Models\Appliances;
use App\Models\AppliancesWorkingStocks;
use App\Models\AppliancesCategories;
use Illuminate\Database\QueryException;
use Auth;
use Illuminate\Support\Carbon;

class AppliancesSalesController extends Controller
{
    public function AppliancesSalesAll(){
        $appliancesSales = AppliancesSales::latest()->get();

        return view('backend.sales.appliances.appliancesSales_all', compact('appliancesSales'));

    }//end of function

    public function AppliancesSalesAdd(){
        $categories = AppliancesCategories::all();
        $suppliers = Supplier::all();
        $brands = Brands::all();
        // $productsCap = ProductsCap::all();
        $existingAppliances = Appliances::all();
        $existingProducts = AppliancesWorkingStocks::select('product_model_id','serial_id','id')->groupBy('product_model_id')->get();
        // $existingProducts = Appliances::select('product_id')->groupBy('product_id')->get();
        // foreach($existingProducts as $productId){
        //     $group[] = Apppliances::where('product_id',$product->product_id)->get();            
        // }

        return view('backend.sales.appliances.appliancesSales_add', compact('categories','suppliers','brands','existingAppliances','existingProducts'));

    }// end of function

    public function AppliancesSalesStore(Request $request){
        
        if($request->category_id == null){
            $notification = array(
                'message' => 'No Data Added', 
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

        
        
        

        // check for duplicates
        $checkDuplicates = false;
        foreach(array_count_values($request->serial) as $val => $c){
            if($c > 1){
                $checkDuplicates = true;               
                break;
            }
        }
        // end check for duplicates

        if($checkDuplicates){
            $notification = array(
                'message' => 'Failed to Save, Duplicate Data Detected!', 
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }else{
            // code to save appliances deliveries
            DB::beginTransaction();
                $row_count = count($request->category_id);
            
                                
                try{
                    for($i = 0; $i < $row_count; $i++){
                    $date               = $request->date[$i];
                    $reference          = $request->reference[$i];
                    $payment_mode       = $request->payment_mode[$i];
                    $category_id        = $request->category_id[$i];
                    $product_model_id   = $request->product_model_id[$i];
                    $serial_id          = $request->serial[$i];
                    $qty                = $request->qty[$i];
                    $remarks            = $request->remarks[$i];
                                
    
                    $related_products =  AppliancesWorkingStocks::select('*')
                                    ->where([
                                        ['product_model_id', '=', $product_model_id],
                                        ['serial_id', '=', $serial_id],
                                        ['category_id', '=', $category_id],
                                    ])
                                    ->first();                    
                    
                    // algo               
                    // save all details of each array to appliances sales table.
                    // deduct the quantity of delivery item from working stocks 
                    // return to appliances sales all and throw all data from appliances sales table.
                    $salesDelivery = new AppliancesSales();
                    $salesDelivery->date_out         = $date;
                    $salesDelivery->reference        = $reference;
                    $salesDelivery->payment_mode     = $payment_mode;
                    $salesDelivery->category_id      = $related_products->category_id;
                    $salesDelivery->supplier_id      = $related_products->supplier_id;
                    $salesDelivery->product_model_id = $related_products->product_model_id;
                    $salesDelivery->serial_number    = $related_products->serial_id;
                    $salesDelivery->brand_id         = $related_products->brand_id;
                    $salesDelivery->description      = $related_products->description;
                    $salesDelivery->unit_cost        = $related_products->unit_cost;
                    $salesDelivery->srp              = $related_products->srp;
                    $salesDelivery->remarks          = $remarks; 
                    $salesDelivery->created_by       = Auth::user()->id;
                    $salesDelivery->created_at       = Carbon::now();     
                    $salesDelivery->save();
                    
                    $si_reference = AppliancesSales::orderBy('id','DESC')->first();
                    // deduction from sales
                    $related_products->qty = $related_products->qty - $qty;
                    $related_products->date_out = $date;
                    $related_products->si_id  = $si_reference->id;
                    $related_products->save();
                     
                    DB::commit();
                    $notification = array(
                        'message' => 'Successfully Added New Sales', 
                        'alert-type' => 'success',
                        );
                        return redirect()->route('appliancesSales.all')->with($notification); 
                    };//end of for loop
                }catch(\Exception $e){                          
                    DB::rollback();
                    dd($e);
                    $notification = array(
                        'message' => 'Something Went Wrong!', 
                        'alert-type' => 'error'
                    );
                    //return back()->with($notification);
                }// end try catch                               
          
        }// end else check duplicates
    }//end of function

    public function AppliancesSalesDelete($id){
        //algo
        //query appliancesales table where id == $id 
        // store result to a variable $salesToDelete
        //query appliances_working_stocks where si_id == $id 
        //store result to a variable $relatedProduct 
        // set $relatedProduct->si_id to null 
        // add the $salesToDelete->qty to $relatedProduct->qty
        //save
        // delete $salesToDelete

        $salesToDelete = AppliancesSales::findOrFail($id);
        $relatedProduct = AppliancesWorkingStocks::where('si_id', $id)->first();
        
        $relatedProduct->si_id = null;
        $relatedProduct->qty = $relatedProduct->qty + $salesToDelete->qty;
        
        
        if($relatedProduct->save() && $salesToDelete->delete()){
            $notification = array(
                'message' => 'Successfully Added New Sales', 
                'alert-type' => 'success',
                );
            return redirect()->route('appliancesSales.all')->with($notification);
        }
        
    }
}
