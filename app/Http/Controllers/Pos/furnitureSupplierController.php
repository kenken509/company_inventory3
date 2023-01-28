<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\furnitureSuppliers;
use Auth;
use Illuminate\Support\Carbon;

class furnitureSupplierController extends Controller
{
    public function FurnitureSupplierAll(){
        $suppliers = furnitureSuppliers::all();

        return view('backend.furnitureSuppliers.furnitureSuppliers_all',compact('suppliers'));
    }// end FurnitureSupplierAll

    public function FurnitureSupplierAdd(){
        return view('backend.furnitureSuppliers.furnitureSuppliers_add');
    }//end FurnitureSupplierAdd

    public function FurnitureSupplierStore(Request $request){
        $duplicate = furnitureSuppliers::where('name',$request->name)->exists();

        if($duplicate){
            $notification = array(
                'message' => 'Existing Supplier!', 
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }else{
            try{
                furnitureSuppliers::insert([
                    'name' => $request->name,
                    'mobileNo' => $request->mobileNo,
                    'email' => $request->email,
                    'address' => $request->address,
                    'name' => $request->name,
                    'createdBy' => Auth::user()->id,
                    'created_at' => Carbon::now(),                
                ]);
    
                $notification = array(
                    'message' => 'Supplier Added Successfully', 
                    'alert-type' => 'success'
                );
        
                return redirect()->route('furnitureSuppliers.all')->with($notification);
            }catch(\Exception $e){

                //dd($e);
                $notification = array(
                    'message' => 'Something Went Wrong!', 
                    'alert-type' => 'error'
                );
                return back()->with($notification);

            }// end try catch
        }//end else if
        
    }// end FurnitureSupplierStore

    public function FurnitureSupplierDelete($id){
        try{
            furnitureSuppliers::findOrFail($id)->delete();
            
            $notification = array(
                'message' => 'Supplier deleted Successfully', 
                'alert-type' => 'success'
            );
    
            return redirect()->route('furnitureSuppliers.all')->with($notification);

        }catch(\Exception $e){
            //dd($e);
            $notification = array(
                'message' => 'Failed to delete supplier', 
                'alert-type' => 'error'
            );

            
            return back()->with($notification);
        }
    }// end FurnitureSupplierDelete

    public function FurnitureSupplierEdit($id){

        $supplier = furnitureSuppliers::findOrFail($id);

        return view('backend.furnitureSuppliers.furnitureSuppliers_edit', compact('supplier'));
    }// end FurnitureSupplierEdit

    public function FurnitureSupplierUpdate(Request $request){
        try{
            furnitureSuppliers::findOrFail($request->id)->update([
                'name'          => $request->name,
                'mobileNo'      => $request->mobileNo,
                'email'         => $request->email,
                'address'       => $request->address,
                'updatedBy'     => Auth::user()->id,            
                'updated_at'    => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Supplier Updated Successfully', 
                'alert-type' => 'success'
            );
    
            return redirect()->route('furnitureSuppliers.all')->with($notification);
        }catch(\Exception $e){
            //dd($e);
            $notification = array(
                'message' => 'Failed to update supplier', 
                'alert-type' => 'error'
            );

            
            return back()->with($notification);
        }
    }// end FurnitureSupplierUpdate
}
