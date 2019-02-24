<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Auth;
use Session;

class UsersController extends Controller
{
    public function register(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
//            check if users is already exist in our database
            $usersCount = User::where('email' , $data['email'])->count();
            if($usersCount > 0){
                return redirect()->back()->with('flash_message_error', 'Email Already Exists');
            } else {
                $user = new User;
                $user->name = ucwords(strtolower($data['name']));
                $user->email = strtolower($data['email']);
                $user->password = bcrypt($data['password']);
                $user->admin = "0";
                $user->save();

                if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
                  Session::put('frontSession', $data['email']);
                    return redirect()->route('cart');
                }
            }


        }

        return view ('frontend.users.login_register');
    }

    public function userlogout(){
        Auth::logout();
        Session::forget('frontSession');
        return redirect('/');
    }

    public function userLogin(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
              Session::put('frontSession', $data['email']);
                return redirect()->route('cart');
            } else {
                return redirect()->back()->with('flash_message_error', 'Invalid Username Solti');
            }
        }
    }


    public function account(){
      return view ('frontend.users.account');
    }
}
