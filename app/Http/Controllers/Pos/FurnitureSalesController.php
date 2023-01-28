<?php

namespace App\Http\Controllers\Pos;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\FurnitureSales;
use App\Models\furnitureSuppliers;
use App\Models\furnitureProducts;
use App\Models\FurnitureCategories;


class FurnitureSalesController extends Controller
{
    public function FurnitureSalesAll(){
        
        $furnitureSales = FurnitureSales::latest()->get();

        return view('backend.sales.furnitures.furnitureSales_all', compact('furnitureSales'));

    }// end FurnitureSalesAll

    public function FurnitureSalesAdd(){
        $suppliers = furnitureSuppliers::all();
        $products = furnitureProducts::all();
        $categories = FurnitureCategories::all(); 

        return view('backend.sales.furnitures.furnitureSales_add', compact('suppliers','products','categories'));
    }// end FurnitureSalesAdd

    public function FurnitureSalesStore(Request $request){
        if($request->category_id == null){
            $notification = array(
                'message' => 'No Data Added', 
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

        //dd($request);
        //check if quantity to sale exceed the stock quantity
        $row_count = count($request->category_id);
        for($i = 0; $i<$row_count;$i++){
            $stockQty = furnitureProducts::select('qty')->where('id', $request->product_model_id[$i])->first();
            
            if($request->qty[$i] > $stockQty->qty){
                $notification = array(
                    'message' => '"'.$request->product_model[$i].'"'.' Selling Quantity Exceeds Current Stock Quantity', 
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            }else{
                DB::beginTransaction();
                try{
                    for($i = 0; $i < $row_count; $i++){
                        $relatedProduct = furnitureProducts::where('id', $request->product_model_id[$i])->first();
                        $soldQty = $relatedProduct->qty - $request->qty[$i];
                        
                        $relatedProduct->update([
                            'qty' => $soldQty,
                            'updated_by' => Auth::user()->id,
                            'updated_at' => Carbon::now(),
                        ]);

                        $furnitureSales = new FurnitureSales();
                        
                        $furnitureSales->reference_name     = $request->reference[$i];
                        $furnitureSales->category_id        = $request->category_id[$i];
                        $furnitureSales->supplier_id        = $relatedProduct->supplier_id;
                        $furnitureSales->product_model_id   = $request->product_model_id[$i];
                        $furnitureSales->qty                = $request->qty[$i];
                        $furnitureSales->unit_cost          = $relatedProduct->unit_cost;
                        $furnitureSales->srp                = $request->srp[$i];
                        $furnitureSales->payment_mode       = $request->payment_mode[$i];
                        $furnitureSales->date_out           = $request->date[$i];
                        $furnitureSales->remarks            = $request->remarks[$i];
                        $furnitureSales->created_by         = Auth::user()->id;
                        $furnitureSales->created_at         = Carbon::now();
                        $furnitureSales->save();                        
                    };

                    DB::commit();
                    $notification = array(
                        'message' => 'Successfully Added New Sales', 
                        'alert-type' => 'success',
                        );
                        return redirect()->route('furnitureSales.all')->with($notification);                                
                }catch(\Exception $e){
                    //dd($e);

                    $notification = array(
                        'message' => 'Something Went Wrong!', 
                        'alert-type' => 'error'
                    );
        
                    return redirect()->back()->with($notification);
                }//end try catch
            } // end else if $request->qty[$i] > $stockQty->qty
        }// end for loop

    }// end FurnitureSalesStore

    public function FurnitureSalesDelete($id){

        DB::beginTransaction();
        try{
            $salesData = FurnitureSales::findOrfail($id);                
            $relatedProduct = furnitureProducts::findOrFail($salesData->product_model_id);

            $qtyUpdate = $relatedProduct->qty + $salesData->qty;

            $relatedProduct->update([
                'qty' => $qtyUpdate,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),
            ]);
            $salesData->delete();

            DB::commit();
            $notification = array(
                'message' => 'Successfully Added New Sales', 
                'alert-type' => 'success',
                );
            return redirect()->route('furnitureSales.all')->with($notification);     
        }catch(\Exception $e){
            //dd($e);
            $notification = array(
                'message' => 'Something Went Wrong!', 
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        }                        
    }
}
