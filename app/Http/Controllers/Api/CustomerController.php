<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\{AppliancesSales, CartItems, Appliances}; 
use App\Models\{FurnitureSales};
use App\Http\Controllers\Controller;
use App\Http\Resources\{UserResource, CartItemResource};
use App\Models\{Orders, OrderCustomer};


class CustomerController extends Controller
{    
    public function customerData(){ 
        
        try{
            $data = Auth::user();
            $data = new UserResource($data);        
            return response()->json($data, 200);
            
        }catch(\Exception $e){
            dd($e);
            return response()->json('You must logged in!');
        }
                             
        
    }
    
    public function addToCart(Request $request){
        $user = Auth::user();

        $productId = $request->product_id;
        $product = Appliances::find($productId);
        $cartItemsPerProduct = $user->cartItemsProduct($productId)->count();
        $workingStocks = $product->getWorkingStock->count();

        if($cartItemsPerProduct < $workingStocks){
            $newCartItem = new CartItems();

            $newCartItem->product_id = $productId;
            $newCartItem->user_id = $user->id;
            $newCartItem->save();
            $data['success'] = true;
        }
        else
            $data['success'] = false;
        return response()->json($data, 200);
    }
   
    public function deleteFromCart(Request $request){
        $user = Auth::user();
        $itemToDelete = CartItems::where('product_id',$request->product_id)
                    ->where('user_id', $user->id)
                    ->get()
                    ->first();

        $itemToDelete->delete();
        
        $data['success'] = true;
        return response()->json($data, 200);
    }
    
    public function submitCheckout(Request $request){

        $user = Auth::user();        

        $newOrder = new Orders();
        $newOrder->customer_id = $user->id;
        $newOrder->customer_name = $request->customer_name;
        $newOrder->customer_address = $request->customer_address;
        $newOrder->customer_email = $request->customer_email;
        $newOrder->customer_contact = $request->customer_contact;
        $newOrder->save();
             
        foreach($user->cartItems as $item){                        
            $newItem = new OrderCustomer();
            $newItem->order_id = $newOrder->id;
            $newItem->product_id = $item->product_id;
            $newItem->amount = $item->getProduct->getDeliveries->srp;
            $newItem->save();            

            $temp = CartItems::find($item->id);
            $temp->delete();
        }

        $data['success'] = true;
        $data['message'] = "Order Submitted";
        return response()->json($data, 200);

    }

    public function customerPayment(){
        return view('website.payment');
    }

    
    

}
 