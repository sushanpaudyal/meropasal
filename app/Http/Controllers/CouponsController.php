<?php

namespace App\Http\Controllers;

use App\Coupon;
use Illuminate\Http\Request;
use Session;

class CouponsController extends Controller
{
    public function addCoupon(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $coupon = new Coupon;
            $coupon->coupon_code = strtoupper($data['coupon_code']);
            $coupon->amount = $data['amount'];
            $coupon->amount_type = $data['amount_type'];
            $coupon->expiry_date = $data['expiry_date'];

            if(empty($data['status'])){
                $coupon->status = 0;
            } else {
                $coupon->status = 1;
            }
            $coupon->save();
            Session::flash('success', 'Coupon Created');
            return redirect()->back();
        }
        return view ('admin.products.add_coupon');
    }
}
