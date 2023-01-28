<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppliancesCategories;
use Auth;
use Illuminate\Support\Carbon;

class AppliancesCategoriesController extends Controller
{
    public function AppliancesCategoriesAll(){
        $categories = AppliancesCategories::latest()->get();

        
        return view('backend.appliancesCategories.appliancesCategories_all',compact('categories'));
    }// end method

    public function AppliancesCategoriesAdd(){
        return view('backend.appliancesCategories.appliancesCategories_add');
    }// end method

    public function AppliancesCategoriesStore(Request $request){
        $categories = AppliancesCategories::all();
        $exist = 0;
        if(AppliancesCategories::where('name', $request->name )->exists()) {
            $notification = array(
                'message' => 'Existing Category', 
                'alert-type' => 'error'
            );
            
            return redirect()->back()->with($notification);
        }else{
            AppliancesCategories::insert([
                'name'          => $request->name,
                'created_by'    => Auth::user()->id,
                'created_at'    => Carbon::now(),
    
            ]);
    
            $notification = array(
                'message' => 'New Category Created Successfully', 
                'alert-type' => 'success'
            );
    
            return redirect()->route('appliancesCategories.all')->with($notification);
        }
        
    }// end of function

    public function AppliancesCategoriesDelete($id){
        AppliancesCategories::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Category Deleted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('appliancesCategories.all')->with($notification);
    }// end of function

    public function AppliancesCategoriesEdit($id){
        $category = AppliancesCategories::findOrFail($id);  
        
        return view('backend.appliancesCategories.appliancesCategories_edit', compact('category'));
    }// end of function

    public function AppliancesCategoriesUpdate(Request $request){
        AppliancesCategories::findOrFail($request->id)->update([
            'name'      => $request->name,
            'updated_by'=> Auth::user()->id,
            'updated_at'=> Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Category Updated Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('appliancesCategories.all')->with($notification);
    }

}
