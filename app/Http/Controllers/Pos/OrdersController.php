<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{Orders, OrderCustomer, AppliancesWorkingStocks, AppliancesSales, Appliances};
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
        //dd($order);
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
        

        try{
            $allPacked = true;
        DB::beginTransaction();
        $order =  Orders::findOrFail($request->id);
        $order->status = 'done';
       
        $items= $order->orders;

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
                
                $supplier_id        = $relatedProduct->supplier_id;
                $category_id        = $relatedProduct->getCategory->id;
                $product_model_id   = $relatedProduct->product_model_id;
                $serial_id          = $relatedProduct->serial_id;
                $qty                = $relatedProduct->qty;
                $remarks            = $relatedProduct->remarks;
                $brand_id           = $relatedProduct->brand_id;
                $description        = $relatedProduct->description;
                $unit_cost          = $relatedProduct->unit_cost;
                $srp                = $relatedProduct->srp;
                                
                
                AppliancesSales::insert([
                    'date_out' => $date,
                    'reference' => $reference,
                    'payment_mode' => '2',
                    'category_id' => $category_id,
                    'supplier_id' => $supplier_id,
                    'product_model_id' => $product_model_id,
                    'serial_number' => $serial_id,
                    'brand_id' => $brand_id,
                    'description' => $description,
                    'unit_cost' => $unit_cost,
                    'srp' => $srp,
                    'remarks' => $remarks,
                ]);
                
                // $onlineSales = new AppliancesSales();
                // $onlineSales->date_out         = $date;
                // $onlineSales->reference        = $reference;
                // $onlineSales->payment_mode     = '2';
                // $onlineSales->product_model_id = $product_model_id;
                // $onlineSales->category_id      = $relatedProduct->category_id;
                // $onlineSales->supplier_id      = $supplier_id;                
                // $onlineSales->serial_number    = $serial_id;
                // $onlineSales->brand_id         = $relatedProduct->brand_id;
                // $onlineSales->description      = $relatedProduct->description;
                // $onlineSales->unit_cost        = $relatedProduct->unit_cost;
                // $onlineSales->srp              = $relatedProduct->srp;
                // $onlineSales->remarks          = $remarks; 
                // $onlineSales->created_by       = Auth::user()->id;
                // $onlineSales->created_at       = Carbon::now();     
                // $onlineSales->save();                                                                        
           
            }// end foreach online sales
            DB::commit();
            $notification = array(
                'message' => 'Successfully Added New Sales', 
                'alert-type' => 'success',
            );
            return redirect()->route('appliancesSales.all')->with($notification);
        }else{
            $notification = array(
                'message' => 'Some items are not packed', 
                'alert-type' => 'error',
            );
            return redirect()->route('orders.view',$request->id)->with($notification);

        }

        }catch(\Exception $e){
            //dd($e);
            DB::rollback();
            $notification = array(
                'message' => 'Something went wrong!', 
                'alert-type' => 'error',
            );
            return redirect()->route('orders.view',$request->id)->with($notification); 
        }        
                
    }//end method

}
