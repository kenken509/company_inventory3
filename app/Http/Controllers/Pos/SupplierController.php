<?php

namespace App\Http\Controllers\Pos;

use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Auth;
use Illuminate\Support\Carbon;

class SupplierController extends Controller
{
    public function SupplierAll(){
        //non fluent
        //DB::select(['table'=> 'posts', 'where' =>['id'=>1]]);

        //fluent
        //DB::table('post')->where('id',1)->get();

        //$suppliers = Supplier::all();
        $suppliers = Supplier::latest()->get();
        return view('backend.supplier.supplier_all', compact('suppliers'));

        

        
    }// End SupplierAll

    public function SupplierAdd(){
        return view('backend.supplier.supplier_add');
    }// End SupplierAdd

    public function SupplierStore(Request $request){
        Supplier::insert([
            'name' => $request->name,
            'mobileNo' => $request->mobileNo,
            'email' => $request->email,
            'address' => $request->address,
            'createdBy' => Auth::user()->id,            
            'created_at' => Carbon::now()            
        ]);

        $notification = array(
            'message' => 'Supplier Added Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('appLiancesSupplier.all')->with($notification);
    }// End Method

    public function SupplierEdit($id){
        $supplier = Supplier::findOrFail($id);
        return view('backend.supplier.supplier_edit', compact('supplier'));
    }// End Method

    public function SupplierUpdate(Request $request){

        $supplierId = $request->id;

        Supplier::findOrFail($supplierId)->update([
            'name' => $request->name,
            'mobileNo' => $request->mobileNo,
            'email' => $request->email,
            'address' => $request->address,
            'updatedBy' => Auth::user()->id,            
            'updated_at' => Carbon::now()           
        ]);

        $notification = array(
            'message' => 'Supplier Updated Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('appLiancesSupplier.all')->with($notification);
    }// End Method

    public function SupplierDelete($id){
        
        try{
            Supplier::findOrFail($id)->delete();

            $notification = array(
                'message' => 'Supplier Deleted Successfully', 
                'alert-type' => 'success'
            );
        }catch(QueryException $e){
            $notification = array(
                'message' => 'Deletion Failed', 
                'alert-type' => 'error'
            );
        }
        

        return redirect()->route('appLiancesSupplier.all')->with($notification);
    }
}
