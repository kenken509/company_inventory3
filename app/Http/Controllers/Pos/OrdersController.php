<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{Orders, OrderCustomer, AppliancesWorkingStocks, AppliancesSales};
use App\Http\Resources\OrderResource;
use Illuminate\Support\Carbon;
use Auth;


class OrdersController extends Controller
{

    public function viewAllOrders(){        
        $orders = OrderResource::collection(Orders::all());        
        return view('backend.orders.view_all_orders',compact('orders'));        
    }

    public function viewOrder($id){
        $order = Orders::find($id);        
        return view('backend.orders.view_order',compact('order'));

    }

    public function orderPackItem(Request $request){        
        $item = OrderCustomer::find($request->id);
        $item->working_stock_id = $request->working_stock_id;
        $item->status = "packed";
        $item->update();
     
        $stock = AppliancesWorkingStocks::find($request->working_stock_id);
        $stock->status = 1;
        $stock->update();

        return redirect()->route('orders.view',$item->order_id);
    }

    public function orderDelivered(Request $request){

        

        

        $allPacked = true;
        $order =  Orders::findOrFail($request->id);
        $order->status = 'done';
       
        $items= $order->orders;

         DB::beginTransaction();
        foreach($items as $item){
            if($item->status == 'packed'){
                $item->status = 'delivered';
                $item->update();
            }else{
                $allPacked = false;
            }                        
        }

        if($allPacked){
            
            $order->update();

            $soldItems = OrderCustomer::select('*')->where('order_id', $request->id)->get();
        
            foreach($soldItems as $item){
            
                $relatedProduct = AppliancesWorkingStocks::where('product_model_id', $item->product_id)->first();
                
                
                $date               = Carbon::now();
                $reference          = 'Online sales';
                $payment_mode       = 2;
                $supplier_id        = $relatedProduct->supplier_id;
                $category_id        = $relatedProduct->category_id;
                $product_model_id   = $relatedProduct->product_model_id;
                $serial_id          = $relatedProduct->serial_id;
                $qty                = $relatedProduct->qty;
                $remarks            = $relatedProduct->remarks;
                                                                        
                // algo               
                // save all details of each array to appliances sales table.
                // deduct the quantity of delivery item from working stocks 
                // return to appliances sales all and throw all data from appliances sales table.

                $onlineSales = new AppliancesSales();
                $onlineSales->date_out         = $date;
                $onlineSales->reference        = $reference;
                $onlineSales->payment_mode     = $payment_mode;
                $onlineSales->category_id      = $category_id;
                $onlineSales->supplier_id      = $supplier_id;
                $onlineSales->product_model_id = $product_model_id;
                $onlineSales->serial_number    = $serial_id;
                $onlineSales->brand_id         = $relatedProduct->brand_id;
                $onlineSales->description      = $relatedProduct->description;
                $onlineSales->unit_cost        = $relatedProduct->unit_cost;
                $onlineSales->srp              = $relatedProduct->srp;
                $onlineSales->remarks          = $remarks; 
                $onlineSales->created_by       = Auth::user()->id;
                $onlineSales->created_at       = Carbon::now();     
                $onlineSales->save();
                                        
                // DB::commit();
                // $notification = array(
                //     'message' => 'Successfully Added New Sales', 
                //     'alert-type' => 'success',
                //     );
                //     return redirect()->route('appliancesSales.all')->with($notification); 
           
            }// end foreach online sales
            DB::commit();
            $notification = array(
                'message' => 'Successfully Added New Sales', 
                'alert-type' => 'success',
            );
            return redirect()->route('appliancesSales.all')->with($notification);
        }
        else{
            DB::rollback();
            $notification = array(
                'message' => 'Some items are not packed', 
                'alert-type' => 'error',
            );
            return redirect()->route('orders.view',$request->id)->with($notification); 
        }
        
        
    }//end method



}