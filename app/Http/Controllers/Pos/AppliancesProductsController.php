<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Carbon;
use App\Models\Appliances;
use App\Models\AppliancesCategories;
use App\Models\Supplier;
use App\Models\Brands;
use App\Models\AppliancesWorkingStocks;
use App\Http\Resources\AppliancesResource;


class AppliancesProductsController extends Controller
{
    public function AppliancesProductsAll(){
        $appliances = Appliances::latest()->get();

        return view('backend.appliancesProducts.appliancesProducts_all', compact('appliances'));
    }//end function 

    public function AppliancesProductsApiAll(){
        $appliances = Appliances::latest()->get();

        return AppliancesResource::collection($appliances);
    }

    public function AppliancesProductsAdd(){
        $appliancesCategories = AppliancesCategories::all();
        $suppliers = Supplier::all();
        $brands = Brands::all();

        return view('backend.appliancesProducts.appliancesProducts_add', compact('appliancesCategories', 'suppliers','brands'));
    }
      

    public function AppliancesProductStore(Request $request){

        if(Appliances::where('product_model', $request->name )->exists()) {
            $notification = array(
                'message' => 'Existing Product', 
                'alert-type' => 'error'
            );
            
            return redirect()->back()->with($notification);
        }else{
            $supplier               = Supplier::findOrFail($request->supplier_id);
            $category               = AppliancesCategories::findOrFail($request->category_id);
            

            $product                = new Appliances;
            $product->product_model = $request->name;
            $product->supplier_id   = $request->supplier_id;
            $product->brand_id      = $request->brand_id;
            $product->description   = $request->description;
            $category->getProducts()->save($product);


            //  $category->getProducts->create([
            //      'name' => $request->name,
            //  ])
        
            $notification = array(
                'message' => 'Data saved successfully', 
                'alert-type' => 'success'
            );
            return redirect()->route('appliancesProducts.all')->with($notification);
        }
        
    }// end of function

    public function AppliancesProductDelete($id){

        try {
            Appliances::findOrFail($id)->delete();
            $notification = array(
                'message' => 'Data Deleted successfully', 
                'alert-type' => 'success'
            );
            return redirect()->route('appliancesProducts.all')->with($notification);
        } catch (\Exception $e) {
            report($e);
     
            $notification = array(
                'message' => 'Deletion Failed', 
                'alert-type' => 'error'
            );
            return redirect()->route('appliancesProducts.all')->with($notification);
        }
        

        

    }// end of function

    public function AppliancesProductEdit($id){                
        $appliances             = Appliances::findOrFail($id);
        $suppliers              = Supplier::all();
        $appliancesCategories   = AppliancesCategories::all();
        return view('backend.appliancesProducts.appliancesProducts_edit', compact('appliances','suppliers', 'appliancesCategories'));
    }//end of function

    public function AppliancesProductUpdate(Request $request){
        // $appliances = AppliancesCategories::findOrFail($request->category_id)
        //         ->getProducts()->where('id', $request->id)->first();

        
        // $appliances->product_model = $request->name;
        // $appliances->supplier_id = $request->supplier_id;
        // $appliances->description = $request->description;
        // $appliances->category_id = $request->category_id;
        // $appliances->update();  
        
        $appliances = Appliances::findOrFail($request->id)->update([
            'product_model' => $request->name,
            'supplier_id' => $request->supplier_id,
            'category_id' => $request->category_id,
            'description' => $request->description,            
        ]);
    
        $notification = array(
            'message' => 'Data Updated successfully', 
            'alert-type' => 'success'
        );
        return redirect()->route('appliancesProducts.all')->with($notification);
    }// end of function

}
