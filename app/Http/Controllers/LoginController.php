<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Artist;
use App\Models\Listerner;
use Hash;
use Auth;
use Toastr;
use Session;

class LoginController extends Controller
{
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        Auth::guard('artist')->logout();
        Auth::guard('listerner')->logout();

        return redirect()->route('loginPage');
    }
    public function loginAttempt(Request $request)
    {

        $userInfo=Admin::where('email',strtolower(trim($request->userName)))->first();

        if(!empty($userInfo)) {

            if(Hash::check($request->password, $userInfo->password)){
                
                if(Auth::guard('admin')->attempt(['email'=>strtolower(trim($request->userName)),'password'=>$request->password])){
                    
                    Session::flash('successMsg',"Logged In Successfully.");

                    return redirect()->route('admin.player');
                }
                else{
                    
                    Session::flash('errMsg',"Cardential Failed.Please Try Again.");

                    return redirect()->back();
                }
            }
            else{
                
                Session::flash('errMsg',"Wrong Password.Please Enter Valid Password.");

                return redirect()->back();  
            }
        }
        
        $userInfo=Artist::where('email',strtolower(trim($request->userName)))->first();

        if(!empty($userInfo)) {
            if(Hash::check($request->password, $userInfo->password)){
                if(Auth::guard('artist')->attempt(['email'=>strtolower(trim($request->userName)),'password'=>$request->password])){
                     Session::flash('successMsg',"Logged In Successfully.");

                    return redirect()->route('artist.player');
                }
                else{
                    
                    Session::flash('errMsg',"Cardential Failed.Please Try Again.");

                    return redirect()->back();
                }
            }
            else{
                
                Session::flash('errMsg',"Wrong Password.Please Enter Valid Password.");

                return redirect()->back();  
            }
        }
       
        $userInfo=Listerner::where('email',strtolower(trim($request->userName)))->first();
        
        if(!empty($userInfo)) {

           if(Hash::check($request->password, $userInfo->password)){
                if(Auth::guard('listerner')->attempt(['email'=>strtolower(trim($request->userName)),'password'=>$request->password])){

                     Session::flash('successMsg',"Logged In Successfully.");

                    return redirect()->route('listerner.player');
                }
                else{
                    
                    Session::flash('errMsg',"Cardential Failed.Please Try Again.");

                    return redirect()->back();
                }
            }
            else{
                
                Session::flash('errMsg',"Wrong Password.Please Enter Valid Password.");

                return redirect()->back();  
            }
        }
        else{

            Session::flash('errMsg',"Invalid Username.Please Enter a Valid Username");

            return redirect()->back();
        }
    }
    public function loginPage(Request $request)
    {
       return view('frontend.login');
    }
    
}
