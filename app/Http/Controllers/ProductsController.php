<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use File;
use Image;
use Session;

class ProductsController extends Controller
{
    public function addProduct(Request $request){

        if($request->isMethod('post')){
            $data = $request->all();
//            echo "<pre>"; print_r($data); die;
//            dd($data);
            $product = new Product;
            if(empty($data['category_id'])){
                return redirect()->back()->with('flash_message_error', 'Under Category is Missing');
            } else {
                $product->category_id = $data['category_id'];
            }

            $product->product_name = ucwords(strtolower($data['product_name']));
            $product->product_code = strtoupper($data['product_code']);
            $product->prodcut_color = $data['product_color'];

            if(!empty($data['description'])){
                $product->description = $data['description'];
            } else {
                $product->description = "";
            }
            $product->price = $data['price'];


            if($request->hasFile('image')){
                $image_tmp = Input::file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(1200,999999).'.'.$extension;

                    $large_image_path = 'public/adminpanel/uploads/products/large/'.$filename;
                    $medium_image_path = 'public/adminpanel/uploads/products/medium/'.$filename;
                    $small_image_path = 'public/adminpanel/uploads/products/small/'.$filename;

                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300,300)->save($small_image_path);

                    $product->image = $filename;

                }
            }

            $product->save();
            return redirect()->back();

        }


        $categories = Category::where(['parent_id' => 0])->get();
          $categories_dropdown = "<option selected disabled> Select</option>";
          foreach($categories as $cat){
              $categories_dropdown .= "<option value='".$cat->id."'>". $cat->name ." </option>";
              $sub_categories = Category::where(['parent_id' => $cat->id])->get();
              foreach($sub_categories as $sub_cat){
                  $categories_dropdown .= "<option value='".$sub_cat->id."'> &nbsp; --- &nbsp; ".$sub_cat->name."</option>";
              }
          }
        return view ('admin.products.add_product', compact('categories_dropdown'));
    }

    public function viewProducts(){
        $products = Product::latest()->get();

        foreach($products as $key => $val){
            $category_name = Category::where(['id' => $val->category_id])->first();
            $products[$key]->category_name = $category_name->name;
        }

        return view ('admin.products.view_products', compact('products'));
    }

    public function editProduct(Request $request, $id){
        $productDetails = Product::where(['id' => $id])->first();

        if($request->isMethod('post')){
            $data = $request->all();

            if($request->hasFile('image')){
                $image_tmp = Input::file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(1200,999999).'.'.$extension;

                    $large_image_path = 'public/adminpanel/uploads/products/large/'.$filename;
                    $medium_image_path = 'public/adminpanel/uploads/products/medium/'.$filename;
                    $small_image_path = 'public/adminpanel/uploads/products/small/'.$filename;

                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300,300)->save($small_image_path);

                }
            } else {
                $filename = $data['current_image'];
            }

            if(empty($data{'description'})){
                $data['description'] = "";
            }

            Product::where(['id' => $id])->update(['category_id' => $data['category_id'], 'product_name' => ucwords(strtolower($data['product_name'])), 'product_code' => $data['product_code'], 'prodcut_color' => $data['product_color'], 'price' => $data['price'], 'description' => $data['description'], 'image' => $filename
            ]);

            Session::flash('success', 'Products Updated Successfully');
            return redirect()->route('product.view');
        }


        $categories = Category::where(['parent_id' => 0])->get();
        $categories_dropdown = "<option value='' selected disabled> Select </option>";
        foreach($categories as $cat){
            if($cat->id == $productDetails->category_id){
                $selected = "selected";
            } else {
                $selected = "";
            }
            $categories_dropdown .= "<option value='".$cat->id."' ".$selected."> ".$cat->name." </option>";

            $sub_categories = Category::where(['parent_id' => $cat->id])->get();
            foreach($sub_categories as $sub_cat){
                if($sub_cat->id == $productDetails->category_id){
                    $selected = "selected";
                } else {
                    $selected = "";
                }

                $categories_dropdown .= "<option value='".$sub_cat->id."' ".$selected."> &nbsp; --- &nbsp; ".$sub_cat->name." </option>";

            }
        }

        return view ('admin.products.edit_product', compact('productDetails', 'categories_dropdown'));
    }

    public function deleteProduct($id = null){
        $product = Product::findOrFail($id);
        $product->delete();
        Session::flash('danger', 'Product Deleted');
        return redirect()->route('product.view');
    }

}
