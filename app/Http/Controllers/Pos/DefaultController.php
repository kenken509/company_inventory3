<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppliancesCategories;
use App\Models\Appliances;
use App\Models\AppliancesWorkingStocks;
use App\Models\Brands; 
use App\Models\furnitureProducts; 
use App\Models\FurnitureCategories;

class DefaultController extends Controller
{
    public function GetCategory(Request $request){
        $supplier_id = $request->supplier_id;

        //dd($supplier_id);

        $allCategories = Appliances::with('category')->select('category_id')->where('supplier_id', $supplier_id)->groupBy('category_id')->get();
        //dd($allCategories);

        return response()->json($allCategories);
        
    }// end GetCategory

    public function GetFurnitureCategories(Request $request){
        $supplier_id = $request->supplier_id;

        $allCategories = furnitureProducts::with('getCategories')->select('category_id')->where('supplier_id', $supplier_id)->groupBy('category_id')->get();
        //dd($allCategories);
        return response()->json($allCategories);
    }//end GetFurnitureCategories

    public function GetProduct(Request $request){
        $category_id = $request->category_id;
        $supplier_id = $request->supplier_id;
        $allProducts = AppliancesCategories::findOrFail($category_id)
                        ->getProducts()
                        ->where('supplier_id',$supplier_id)
                        ->groupBy('product_model')
                        ->get();
        
        //dd($allProducts);
        return response()->json($allProducts);
    }// end GetProduct

    public function GetFurnitureProducts(Request $request){
        $category_id = $request->category_id;
        $supplier_id = $request->supplier_id;
        $allProducts = FurnitureCategories::findOrFail($category_id)
                        ->getProducts()
                        ->where('supplier_id',$supplier_id)
                        ->groupBy('product_model')
                        ->get();
        
        return response()->json($allProducts);
    }

    public function GetWorkingProducts(Request $request){
        $category_id = $request->category_id;

        $workingProducts = AppliancesWorkingStocks::with('getProduct')->where('category_id',$category_id)->groupBy('product_model_id')->where('qty','>=',1)->get();                        
        
        return response()->json($workingProducts);
    }

    public function GetBrands(Request $request){
        $brands = Brands::all();
        
        $allBrands = Appliances::with('getBrand')->select('brand_id')->where('id', $request->product_model)->get();
              
        return response()->json($allBrands);
    }// end function
    
    public function GetSerials(Request $request){        

        $product = AppliancesWorkingStocks::with('getSerial')->select('*')->where('product_model_id',$request->product_model_id)->where('qty','>=',1)->get();                            
        
        // foreach($product as $serial){
        //     print_r($serial.'<br>');
        // }

        return response()->json($product);
    }//end function

    
    public function GetWorkingFurnitures(Request $request){
        $product = furnitureProducts::select('*')->where([
                ['category_id','=', $request->category_id],
                ['qty','>', '0'],
            ])->get();

        return response()->json($product);
    }// end GetWorkingFurnitures

    public function GetFurniturePrice(Request $request){
        $productPrice = furnitureProducts::select('unit_cost', 'srp_gdp')->where('id', $request->product_model_id)->first();
        
        return response($productPrice);
    }
}
