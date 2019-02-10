<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Product;

class CartController extends Controller
{
    public function addtoCart(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            if(empty($data['user_email'])){
                $data['user_email'] = "";
            }

            $session_id = Session::get('session_id');
            if(empty($session_id)){
                $session_id = str_random(40);
                Session::put('session_id', $session_id);
            }

            $sizeArr = explode("-", $data['size']);

            DB::table('carts')->insert([
                'product_id' => $data['product_id'] , 'product_name' => $data['product_name'] , 'product_code' => $data['product_code'], 'product_color' => $data['prodcut_color'] , 'price' => $data['price'], 'size' => $sizeArr[1], 'quantity' => $data['quantity'], 'user_email' => $data['user_email'], 'session_id' => $session_id
            ]);

            return redirect()->route('cart');
        }
    }


    public function cart(){
        $session_id = Session::get('session_id');
        $userCart = DB::table('carts')->where(['session_id' => $session_id])->get();
           foreach($userCart as $key => $product){
               $productDetails = Product::where('id', $product->product_id)->first();
               $userCart[$key]->image = $productDetails->image;
           }


        return view ('frontend.products.cart', compact('userCart'));
    }
}
