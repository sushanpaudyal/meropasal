<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class CartController extends Controller
{
    public function addtoCart(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            if(empty($data['user_email'])){
                $data['user_email'] = "";
            }
            if(empty($data['session_id'])){
                $data['session_id'] = "";
            }

            $sizeArr = explode("-", $data['size']);

            DB::table('carts')->insert([
                'product_id' => $data['product_id'] , 'product_name' => $data['product_name'] , 'product_code' => $data['product_code'], 'product_color' => $data['prodcut_color'] , 'price' => $data['price'], 'size' => $sizeArr[1], 'quantity' => $data['quantity'], 'user_email' => $data['user_email'], 'session_id' => $data['session_id']
            ]);
        }
    }
}
