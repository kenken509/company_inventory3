<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Carbon;
use App\Models\furnitureProducts;
use App\MOdels\furnitureSuppliers;
use App\MOdels\FurnitureCategories;

class furnitureProductsController extends Controller
{
    public function FurnitureProductsAll(){
        $furnitures = furnitureProducts::latest()->get();

        return view('backend.furnitureProducts.furnitureProducts_all', compact('furnitures'));
        
    }//end FurnitureProductsAll

    public function FurnitureProductsAdd(){
        $suppliers  = furnitureSuppliers::all();
        $categories = FurnitureCategories::all();
        return view('backend.furnitureProducts.furnitureProducts_add', compact('suppliers','categories'));
    }// end FurnitureProductsAdd

    public function FurnitureProductsStore(Request $request){
        $duplicate = furnitureProducts::where('product_model',$request->name)->exists();
        
        if($duplicate){
            $notification = array(
                'message'       => 'Existing Product!', 
                'alert-type'    => 'error',
            );

            return back()->with($notification);
        }else{
            try{
                furnitureProducts::insert([
                    'supplier_id'   => $request->supplier_id,
                    'category_id'   => $request->category_id,
                    'product_model' => $request->name,
                    'description'   => $request->description,
                    'created_by'    => Auth::user()->id,
                    'created_at'    => Carbon::now(),
                ]);
    
                $notification = array(
                    'message' => 'New Product Created successfully', 
                    'alert-type' => 'success'
                );
                return redirect()->route('furnitureProducts.all')->with($notification);
    
            }catch(\Exception $e){
                //dd($e);
                $notification = array(
                    'message' => 'Something went wrong!', 
                    'alert-type' => 'error'
                );
                return back()->with($notification);
            }

        }// end if else       
    }//end of FurnitureProductsStore

    public function FurnitureProductsDelete($id){
         
        try{
            furnitureProducts::findOrFail($id)->delete();

            $notification = array(
                'message' => 'Deleted successfully!', 
                'alert-type' => 'success'
            );
            return redirect()->route('furnitureProducts.all')->with($notification);
        }catch(\Exception $e){
            $notification = array(
                'message' => 'Failed to delete!', 
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
        
    }//end of FurnitureProductsDelete

    public function FurnitureProductsEdit($id){
        $suppliers          = furnitureSuppliers::all();
        $categories         = FurnitureCategories::all();
        $furnitureToEdit    = furnitureProducts::findOrFail($id);

        return view('backend.furnitureProducts.furnitureProducts_edit', compact('furnitureToEdit','suppliers','categories'));
    }// end furnitureproductsedit

    public function FurnitureProductsUpdate(Request $request){
        try{
            furnitureProducts::findOrFail($request->id)->update([
                'supplier_id'   => $request->supplier_id,
                'category_id'   => $request->category_id, 
                'product_model' => $request->name,
                'description'   => $request->description,
                'updated_by'    => Auth::user()->id,
                'updated_at'    => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Updated successfully!', 
                'alert-type' => 'success'
            );
            return redirect()->route('furnitureProducts.all')->with($notification);

        }catch(\Exception $e){
            //dd($e);
            $notification = array(
                'message' => 'Failed to Update!, Something Went Wrong!', 
                'alert-type' => 'error'
            );
            return back()->with($notification);

        }//end try catch                
    }// end FurnitureProductsUpdate
}
