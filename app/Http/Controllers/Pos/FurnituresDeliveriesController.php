<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\furnituresDeliveries;
use App\Models\furnitureSuppliers;
use App\Models\furnitureProducts;
use App\Models\FurnitureCategories;
use App\Models\FurnitureDefectives;
use App\Models\Supplier;
use App\Models\ProductsCap;
use App\Models\FurnitureWorkingStocks;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Carbon;

class FurnituresDeliveriesController extends Controller
{
    public function FurnitureDeliveriesAll(){
        
        $furnitureDeliveries = furnituresDeliveries::latest()->get();                             
        return view('backend.furnituresDeliveries.furnituresDeliveries_all', compact('furnitureDeliveries'));
    }// end of FurnitureDeliveriesAll

    public function FurnitureDeliveriesAdd(){
        $suppliers = furnitureSuppliers::all();
        $products = furnitureProducts::all();
        $categories = FurnitureCategories::all();

        return view('backend.furnituresDeliveries.furnitureDeliveries_add', compact('suppliers','products','categories'));
    } //end FurnitureDeliveriesAdd

    public function FurnitureDeliveriesStore(Request $request){                        
        
        DB::beginTransaction();
        try{
            if($request->category_id == null){
                $notification = array(
                    'message' => 'No data Added', 
                    'alert-type' => 'error'
                );
    
                return redirect()->back()->with($notification);
            }else{
                $count_category = count($request->category_id);                
                
                for($i = 0; $i < $count_category; $i++){ 
                   
                    //check if status is defective                
                    if($request->status[$i] == 1){
                        $defective = new FurnitureDefectives();

                        $defective->product_model_id    = $request->product_model_id[$i];
                        $defective->supplier_id         = $request->supplier_id[$i];
                        $defective->category_id         = $request->category_id[$i];
                        $defective->dr_id               = $request->reference_name[$i];
                        $defective->qty                 = $request->qty[$i];
                        $defective->unit_cost           = $request->unit_cost[$i];
                        $defective->date_in             = $request->date_in[$i];
                        $defective->status              = $request->status[$i];
                        $defective->remarks             = $request->remarks[$i];
                        $defective->created_by          = Auth::user()->id;
                        $defective->created_at          = Carbon::now();
                        $defective->save();


                    }else{
                        $deliveries = new furnituresDeliveries();
                    
                        $deliveries->date_in            = $request->date_in[$i];
                        $deliveries->category_id        = $request->category_id[$i];
                        $deliveries->supplier_id        = $request->supplier_id[$i];
                        $deliveries->product_model_id   = $request->product_model_id[$i];
                        $deliveries->qty                = $request->qty[$i];
                        $deliveries->unit_cost          = $request->unit_cost[$i];
                        $deliveries->srp                = $request->srp[$i];
                        $deliveries->reference_name     = $request->reference_name[$i];
                        $deliveries->status             = $request->status[$i];
                        $deliveries->remarks            = $request->remarks[$i];
                        $deliveries->created_by         = Auth::user()->id;
                        $deliveries->created_at         = Carbon::now();
                        $deliveries->save();

                        $id = $request->product_model_id[$i]; 
                        
                        $product =  furnitureProducts::where('id', $id)->first();
                        
                        $product->update([
                            'qty'           => $product->qty + $request->qty[$i],
                            'unit_cost'     => $request->unit_cost[$i],
                            'srp_gdp'       => $request->srp[$i],
                            'updated_by'    => Auth::user()->id,
                            'updated_at'    => Carbon::now(),
                        ]);        
                    }//end else check if status is defective                                                                                       
                }// end for loop
                           
            }// end if else $request->category_id
        }catch(\Exception $e){
            DB::rollback();
            //dd($e);
            $notification = array(
                'message' => 'Something Went Wrong!', 
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        }
        
        DB::commit();
        $notification = array(
            'message' => 'Data saved successfully', 
            'alert-type' => 'success'
        );
        return redirect()->route('furnitureDeliveries.all')->with($notification);    
    }// end FurnitureDeliveriesStore

    public function FurnitureDeliveriesDelete($id){
        DB::beginTransaction();
        try{
            $deliveryToDelete = furnituresDeliveries::findOrFail($id);        
        
            $deliverRelatedProductId = $deliveryToDelete->product_model_id;
            
            $deliverRelatedProduct = furnitureProducts::findOrFail($deliverRelatedProductId);
            
            $quantity = $deliverRelatedProduct->qty - $deliveryToDelete->qty;
            
            //update related product qty
            $deliverRelatedProduct->update([
                'qty' => $quantity,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),
            ]);
            
            $deliveryToDelete->delete();
        }catch(\Exception $e){
            //dd($e);
            $notification = array(
                'message' => 'Something Went Wrong!', 
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        }

        DB::commit();
        $notification = array(
            'message' => 'Data saved successfully', 
            'alert-type' => 'success'
        );
        return redirect()->route('furnitureDeliveries.all')->with($notification);
    }// end FurnitureDeliveriesDelete

    
}
