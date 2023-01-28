<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brands;
use Auth;
use Illuminate\Support\Carbon;

class BrandsController extends Controller
{
    public function BrandsAll(){
        $brands = Brands::latest()->get();

        return view('backend.brands.brands_all', compact('brands'));
    }// end of function

    public function BrandAdd(){
        return view('backend.brands.brand_add');
    }// end of function

    public function BrandStore(Request $request){
        $save = Brands::insert([
            'name'          => $request->name,
            'created_by'    => Auth::user()->id,
            'created_at'    => Carbon::now(),
        ]);

        if($save){
            $notification = array(
                'message' => 'New Brand Created Successfully', 
                'alert-type' => 'success'
            );
    
            return redirect()->route('brands.all')->with($notification);
        }else{
            $notification = array(
                'message' => 'Error Occurred! Please check your inputs', 
                'alert-type' => 'error'
            );
    
            return redirect()->back()->with($notification);
        }
        
    }// end of function

    public function BrandEdit($id){
        $brand = Brands::findOrFail($id);

        return view('backend.brands.brand_edit', compact('brand'));
    }// end of function

    public function BrandUpdate(Request $request){
        $updateBrand = Brands::findOrFail($request->id)->update([
            'name' => $request->name,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);

        if($updateBrand){
            $notification = array(
                'message' => 'Brand Updated Successfully', 
                'alert-type' => 'success'
            );
    
            return redirect()->route('brands.all')->with($notification);
        }else{
            $notification = array(
                'message' => 'Update Failed', 
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        }
    }// end of function

    public function BrandDelete($id){
        try{
            Brands::findOrFail($id)->delete();

            $notification = array(
                'message' => 'Brand Deleted Successfully', 
                'alert-type' => 'success'
            );
            return redirect()->route('brands.all')->with($notification);
        }catch(\Exception $e){
            $notification = array(
                'message' => 'Deletion Failed', 
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
        

        
    }
}
