<?php

namespace App\Http\Controllers;

use App\Cart;
use App\ProductsAttribute;
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

            $countProducts = DB::table('carts')->where(['product_id' => $data['product_id'], 'product_color' => $data['prodcut_color'], 'size' => $sizeArr[1] , 'session_id' => $session_id])->count();

            if($countProducts > 0){
                return redirect()->back()->with('flash_message_success', 'Cart Item Already Exixts');
            } else {

                $getSKU = ProductsAttribute::select('sku')->where(['product_id' => $data['product_id'], 'size' => $sizeArr[1]])->first();

                DB::table('carts')->insert([
                    'product_id' => $data['product_id'] , 'product_name' => $data['product_name'] , 'product_code' => $getSKU->sku, 'product_color' => $data['prodcut_color'] , 'price' => $data['price'], 'size' => $sizeArr[1], 'quantity' => $data['quantity'], 'user_email' => $data['user_email'], 'session_id' => $session_id
                ]);
            }

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

    public function deleteCart($id){
        $cart = Cart::findOrFail($id);
        $cart->delete();
        return redirect()->back()->with('flash_message_success', 'Cart Item Deleted');
    }

    public function updateCartQuantity($id, $quantity){

        $getCartDetails = DB::table('carts')->where('id', $id)->first();
        $getAttributeStock = ProductsAttribute::where('sku', $getCartDetails->product_code)->first();

        $updated_qunatity = $getCartDetails->quantity + $quantity;

        if($getAttributeStock->stock >= $updated_qunatity){
            DB::table('carts')->where('id', $id)->increment('quantity', $quantity);
            return redirect()->back()->with('flash_message_success', 'Cart Has Been Updated');
        } else {
            return redirect()->back()->with('flash_message_success', 'Prodcut Required Quantity is Out of Stock');
        }


    }
}
