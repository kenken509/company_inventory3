<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories;
use Auth;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;


class CategoriesController extends Controller
{
    public function CategoriesAll(){
        $categories = Categories::all();
        
        
        return view('backend.categories.categories_all', compact('categories'));
    }// end of function

    public function CategoryAdd(){

        return view('backend.categories.category_add');
    }// end of function

    public function CategoryStore(Request $request){
        Categories::insert([
            'name' => $request->name,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'New Category Created Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('categories.all')->with($notification);

    }// end of function

    public function CategoryEdit($id){
        $categoryToEdit = Categories::findOrFail($id);

        return view('backend.categories.category_edit', compact('categoryToEdit'));
    }// end of function

    public function CategoryUpdate(Request $request){

        //$categoy = Categories::findOrFail($request->id);

        Categories::findOrFail($request->id)->update([
            'name' => $request->name,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Updated Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('categories.all')->with($notification);
    }// end of function

    public function CategoryDelete($id){
        try{
            Categories::findOrFail($id)->delete();

            $notification = array(
                'message' => 'Deleted Successfully', 
                'alert-type' => 'success'
            );            
        }catch(QueryException $e){            
            $notification = array(
                'message' => 'Deletion Failed', 
                'alert-type' => 'error'
            );            
        }
        return redirect()->route('categories.all')->with($notification);
    }// end of function
    
}
