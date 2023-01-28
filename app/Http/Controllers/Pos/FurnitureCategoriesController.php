<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FurnitureCategories;
use Auth;
use Illuminate\Support\Carbon;

class FurnitureCategoriesController extends Controller
{
    public function FurnitureCategoriesAll(){
        $categories = FurnitureCategories::all();

        return view('backend.furnitureCategories.furnitureCategories_all', compact('categories'));
    }//end of FurnitureCategoriesAll

    public function FurnitureCategoriesEdit($id){
        $category = FurnitureCategories::findOrFail($id);
        
        return view('backend.furnitureCategories.furnitureCategory_edit', compact('category'));
    }// end of FurnitureCategoriesEdit

    public function FurnitureCategoriesUpdate(Request $request){
       
        try{
            $update = FurnitureCategories::findOrFail($request->id)->update([
                'name' => $request->name,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),
            ]);
            
            $notification = array(
                'message' => 'Data updated successfully', 
                'alert-type' => 'success'
            );
            return redirect()->route('furnitureCategories.all')->with($notification);
        }catch(\Exception $e){
            $notification = array(
                'message' => 'Update failed', 
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }// end of try catch        
    }// end of FurnitureCategoriesUpdate

    public function FurnitureCategoriesAdd(){

        return view('backend.furnitureCategories.furnitureCategory_add');
    }// end of FurnitureCategoriesAdd

    public function FurnitureCategoriesStore(Request $request){
        $duplicate = FurnitureCategories::where('name',$request->name)->exists();
        
        if($duplicate){
            $notification = array(
                'message' => $request->name.' category already exists!', 
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }else{
            try{
                FurnitureCategories::insert([
                    'name' => $request->name,
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now(),
                ]);

                $notification = array(
                    'message' => 'New Category Created successfully', 
                    'alert-type' => 'success'
                );
                return redirect()->route('furnitureCategories.all')->with($notification);
            }catch(\Exception $e){
                $notification = array(
                    'message' => 'Something went wrong!', 
                    'alert-type' => 'error'
                );
                return back()->with($notification);
            }//end of try catch
        }// end if else        
    }// end of FurnitureCategoriesStore 
    public function FurnitureCategoriesDelete($id){
        try{
            FurnitureCategories::findOrFail($id)->delete();

            $notification = array(
                'message' => 'Deleted successfully!', 
                'alert-type' => 'success'
            );
            return redirect()->route('furnitureCategories.all')->with($notification);
        }catch(\Exception $e){
            $notification = array(
                'message' => 'Failed to delete!', 
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }
}
