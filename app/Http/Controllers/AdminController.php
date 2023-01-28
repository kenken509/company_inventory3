<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\AppliancesSales; 
use App\Models\FurnitureSales;
use Illuminate\Support\Carbon;
use App\Models\AppliancesDefectives;
use App\Models\FurnitureDefectives;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{    
    public function dashboard(){       
        if(Auth::user()->role == 0)
            return redirect('/');

        
        $curentMonth = Carbon::now()->format('F Y');
        //**********START OF APPLIANCES SOLD **********    
        $currentMonthAppliancesSold = AppliancesSales::select('*')->whereMonth('date_out', Carbon::now()->month)->sum('qty');          
        $previousMonthAppliancesSold    = AppliancesSales::select('*')
                                    ->whereBetween('date_out',
                                        [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()]
                                    )->sum('qty');  
                              
        
        $percentageIncreaseApp         = "";
        $percentageDecreaseApp         = "";
        $equalApp                      = false;
        
        //if currentMonthAppliancesSold is greater than last month sold
        if($currentMonthAppliancesSold > $previousMonthAppliancesSold){

            if($previousMonthAppliancesSold == 0){                
                $percentageIncreaseApp  = $currentMonthAppliancesSold*100;
                $percentageDecreaseApp  = "";
            }else{
                $percentageIncreaseApp  = (($currentMonthAppliancesSold-$previousMonthAppliancesSold)/$previousMonthAppliancesSold)*100;
                $percentageDecreaseApp  = "";
            }
            
        }else if($currentMonthAppliancesSold < $previousMonthAppliancesSold){
            //if currentMonthAppliancesSold is less than last month sold
            if($previousMonthAppliancesSold == 0){                
                $currentMonthAppliancesSold  = $previousMonthAppliancesSold*100;
                $percentageDecreaseApp       = "";
            }else{
                $percentageDecreaseApp = (($previousMonthAppliancesSold-$currentMonthAppliancesSold)/$previousMonthAppliancesSold)*100;
                $percentageIncreaseApp = "";                
            }            
            
            
        }else{
            $percentageIncrease = "";
            $percentageDecrease = "";
            $equalApp           = true;
            
        };//**********END OF APPLIANCES SOLD **********    

        //**********START OF FURNITURE SOLD **********    
        $currentMonthFurnitureSold      = FurnitureSales::select('*')
                                        ->whereMonth('date_out', Carbon::now()->month)
                                        ->sum('qty'); 

        $previoustMonthFurnitureSold    = FurnitureSales::select('*')
                                        ->whereBetween('date_out',
                                            [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()]
                                        )->sum('qty');   

        $percentageIncreaseFur          = "";
        $percentageDecreaseFur          = "";
        $equalFur                       = false;

        if($currentMonthFurnitureSold > $previoustMonthFurnitureSold){

            if($previoustMonthFurnitureSold == 0){                
                $percentageIncreaseFur  = $currentMonthFurnitureSold*100;
                $percentageDecreaseFur  = "";
            }else{
                $percentageIncreaseFur  = (($currentMonthFurnitureSold-$previoustMonthFurnitureSold)/$previoustMonthFurnitureSold)*100;
                $percentageDecreaseFur  = "";
            }
            
        }else if($currentMonthFurnitureSold < $previoustMonthFurnitureSold){
            //if currentMonthFurnitureSold is less than last month sold  
            if($currentMonthFurnitureSold == 0){                
                $percentageDecreaseFur  = $previoustMonthFurnitureSold*100;
                $percentageIncreaseFur  = "";
            }else{
                $percentageDecreaseFur = (($previoustMonthFurnitureSold-$currentMonthFurnitureSold)/$previoustMonthFurnitureSold)*100;
                $percentageIncreaseFur = "";
                $equalFur              = "";
            }          
           
            
        }else{
            $percentageIncreaseFur = "";
            $percentageDecreaseFur = "";
            $equalFur              = true;            
        };                                            
        //**********END OF FURNITURE SOLD ********** 
        
        //**********START OF DEFECTIVE APPLIANCES **********
        $totalDefectiveApp          = AppliancesDefectives::where('status', 1)->sum('qty');          
        $currentMonthDefetiveApp    = AppliancesDefectives::where('status', 1)
                                    ->whereMonth('date_in', Carbon::now()->month)
                                    ->sum('qty');

        $previousMonthDefectiveApp  = AppliancesDefectives::select('*')
                                    ->whereBetween('date_in',
                                        [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()]
                                    )->sum('qty');
        
        // $currentMonthDefetiveApp = 1;
        // $previousMonthDefectiveApp = 1;
        // $totalDefectiveApp = $currentMonthDefetiveApp + $previousMonthDefectiveApp;

        $increaseDefApp = "";
        $decreaseDefApp = "";
        $noDefApp    = false;
        $evenApp = false;


        if($currentMonthDefetiveApp == 0){
            $increaseDefApp         = "";
            $decreaseDefApp         = "";
            $noDefApp = true;
        }else if($currentMonthDefetiveApp == $previousMonthDefectiveApp){
            $evenApp = true;
            $increaseDefApp = "";
            $decreaseDefApp = "";
            $noDefApp       = false;   
        
        }else if($currentMonthDefetiveApp > $previousMonthDefectiveApp ){
            if($previousMonthDefectiveApp == 0){                
                $increaseDefApp         = $currentMonthDefetiveApp*100;
                $decreaseDefApp         = "";
                $noDefApp               = false;
                $evenApp = true;
            }else{
                $increaseDefApp  = (($currentMonthDefetiveApp-$previousMonthDefectiveApp)/$previousMonthDefectiveApp)*100;
                $decreaseDefApp  = "";
                $noDefApp    = false;
                
            }
            
        }else if($currentMonthDefetiveApp < $previousMonthDefectiveApp){
             
            if($currentMonthDefetiveApp == 0){                
                $decreaseDefApp  = $previousMonthDefectiveApp*100;
                $noDefApp  = "";
            }else{
                $decreaseDefApp = (($previousMonthDefectiveApp-$currentMonthDefetiveApp)/$previousMonthDefectiveApp)*100;
                $increaseDefApp = "";
                $noDefApp       = "";
                
            }                                 
        }
        
        //**********END OF DEFECTIVE APPLIANCES **********

        //**********START OF DEFECTIVE FURNITURES **********
        $totalDefectiveFur          = FurnitureDefectives::where('status', 1)->sum('qty');
        $currentMonthDefetiveFur    = FurnitureDefectives::select('*')->where('status', 1)->whereMonth('date_in',Carbon::now()->month)->sum('qty');
        $previousMonthDefectiveFur  = FurnitureDefectives::select('*')->where('status', 1)->whereBetween('date_in',
                                        [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()]    
                                    )->sum('qty');
        
        // $currentMonthDefetiveFur   = 5;
        // $previousMonthDefectiveFur = 2;
        // $totalDefectiveFur = $currentMonthDefetiveFur+$previousMonthDefectiveFur;

        $increaseDefFur = "";
        $decreaseDefFur = "";
        $even = false;
        $noDefFur       = false;    
        
        if($currentMonthDefetiveFur == 0){
            $increaseDefFur         = "";
            $decreaseDefFur         = "";
            $noDefFur = true;
        }else if($currentMonthDefetiveFur == $previousMonthDefectiveFur){
            $even           = true;
            $increaseDefFur = "";
            $decreaseDefFur = "";
            $noDefFur       = false;   
        
        }else if($currentMonthDefetiveFur > $previousMonthDefectiveFur ){
            if($previousMonthDefectiveFur == 0){                
                $increaseDefFur         = $currentMonthDefetiveFur*100;
                $decreaseDefFur         = "";
                $noDefFur               = false;
                
            }else{
                $increaseDefFur  = (($currentMonthDefetiveFur-$previousMonthDefectiveFur)/$previousMonthDefectiveFur)*100;
                $decreaseDefFur  = "";
                $noDefFur    = false;
                
            }
            
        }else if($currentMonthDefetiveFur < $previousMonthDefectiveFur){
             
            if($currentMonthDefetiveFur == 0){                
                $decreaseDefFur  = $previousMonthDefectiveFur*100;
                $noDefFur  = "";
            }else{
                $decreaseDefFur = (($previousMonthDefectiveFur-$currentMonthDefetiveFur)/$previousMonthDefectiveFur)*100;
                $increaseDefFur = "";
                $noDefFur       = "";
                
            }                                 
        }
        //**********END OF DEFECTIVE FURNITURES **********

        //**** START OF APPLIANCES BEST SELLERS *********
        $bestSellersApp = AppliancesSales::whereMonth('date_out', Carbon::now()->month)->groupBy('product_model_id')
                    ->selectRaw('count(*) as total, product_model_id, supplier_id, category_id, brand_id')->limit(10)
                    ->get();

        $bestSellersApp->sortByDesc('total');
        
        //**** END OF APPLIANCES BEST SELLERS *********

        //**** START OF FURNITURE BEST SELLERS *********
        $bestSellersFur = FurnitureSales::whereMonth('date_out', Carbon::now()->month)->groupBy('product_model_id')
                    ->selectRaw('sum(qty) as total, product_model_id, supplier_id, category_id')->orderBy('total','desc')->limit(10)
                    ->get();

        
        

        
        
        //**** END OF FURNITURE BEST SELLERS *********
        return view('admin.index', compact(
            'currentMonthAppliancesSold',
            'percentageIncreaseApp', 
            'percentageDecreaseApp', 
            'equalApp', 
            'curentMonth',
            'currentMonthFurnitureSold',
            'percentageIncreaseFur',
            'percentageDecreaseFur',
            'equalFur',
            'totalDefectiveApp',
            'currentMonthDefetiveApp',
            'increaseDefApp',
            'decreaseDefApp',
            'noDefApp',
            'evenApp',
            'totalDefectiveFur',
            'currentMonthDefetiveFur',
            'previousMonthDefectiveFur',
            'even',
            'increaseDefFur', 
            'decreaseDefFur',           
            'noDefFur',
            'bestSellersApp',
            'bestSellersFur'
        ));
    }
    
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification = array(
            'message' => 'User Logout Successfully', 
            'alert-type' => 'success'
        );

        return redirect('/')->with($notification);
    } // End Method 


    public function Profile(){
        $id = Auth::user()->id;
        $adminData = User::find($id);
        return view('admin.admin_profile_view',compact('adminData'));

    }// End Method 


    public function EditProfile(){

        $id = Auth::user()->id;
        $editData = User::find($id);
        return view('admin.admin_profile_edit',compact('editData'));
    }// End Method 

    public function StoreProfile(Request $request){
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->username = $request->username;

        if ($request->file('profile_image')) {
           $file = $request->file('profile_image');

           $filename = date('YmdHi').$file->getClientOriginalName();
           $file->move(public_path('upload/admin_images'),$filename);
           $data['profile_image'] = $filename;
        }
        $data->save();

        $notification = array(
            'message' => 'Admin Profile Updated Successfully', 
            'alert-type' => 'info'
        );

        return redirect()->route('admin.profile')->with($notification);

    }// End Method


    public function ChangePassword(){

        return view('admin.admin_change_password');

    }// End Method


    public function UpdatePassword(Request $request){

        $validateData = $request->validate([
            'oldpassword' => 'required',
            'newpassword' => 'required',
            'confirm_password' => 'required|same:newpassword',

        ]);

        $hashedPassword = Auth::user()->password;
        if (Hash::check($request->oldpassword,$hashedPassword )) {
            $users = User::find(Auth::id());
            $users->password = bcrypt($request->newpassword);
            $users->save();

            session()->flash('message','Password Updated Successfully');
            return redirect()->back();
        } else{
            session()->flash('message','Old password is not match');
            return redirect()->back();
        }

    }// End Method



}
 