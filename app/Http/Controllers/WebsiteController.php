<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class WebsiteController extends Controller
{    
    public function home(){   
                  
        return view('website.home');
    }
    
    public function checkout(){
        return view('website.checkout');
    }



}
 