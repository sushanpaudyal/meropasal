<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\ProductsAttribute;
use App\ProductsImage;
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

            if(!empty($data['care'])){
                $product->care = $data['care'];
            } else {
                $product->care = "";
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
            if(empty($data{'care'})){
                $data['care'] = "";
            }
            Product::where(['id' => $id])->update(['category_id' => $data['category_id'], 'product_name' => ucwords(strtolower($data['product_name'])), 'product_code' => $data['product_code'], 'prodcut_color' => $data['product_color'], 'price' => $data['price'], 'description' => $data['description'], 'image' => $filename, 'care' => $data['care']
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

    public function addAttributes(Request $request, $id = null){
        $productDetails = Product::with('attributes')->where(['id' => $id])->first();

        if($request->isMethod('post')){
            $data = $request->all();
//            echo "<pre>"; print_r($data); die;
            foreach($data['sku'] as $key => $val){
                if(!empty($val)){

//                    SKU Check
                $attrCountSKU = ProductsAttribute::where('sku', $val)->count();
                if($attrCountSKU > 0){
                    return redirect()->back()->with('flash_message_error', 'SKU Already Exists');
                }

//                Size Check
                $attrCountSizes = ProductsAttribute::where(['product_id' => $id, 'size' => $data['size'][$key]])->count();
                if($attrCountSizes > 0){
                    return redirect()->back()->with('flash_message_error', 'Size Already Exists');
                }

                    $attribute = new ProductsAttribute;
                    $attribute->product_id = $data['product_id'];
                    $attribute->sku = $val;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->save();
                }
            }
            Session::flash('success', 'Attribute Has Been Added Successfully');
            return redirect()->back();

        }

        return view ('admin.products.add_attributes', compact('productDetails'));
    }

    public function deleteAttribute($id){
        $attribute = ProductsAttribute::findOrFail($id);
        $attribute->delete();
        Session::flash('danger', 'Product Attribute Has Been Deleted Successfully');
        return redirect()->back();
    }



    public function deleteProductImage($id = null){
        $productImage = Product::where(['id' => $id])->first();

        $large_image_path = 'public/adminpanel/uploads/products/large/';
        $medium_image_path = 'public/adminpanel/uploads/products/medium/';
        $small_image_path = 'public/adminpanel/uploads/products/small/';

        if(file_exists($large_image_path.$productImage->image)){
            unlink($large_image_path.$productImage->image);
        }
        if(file_exists($small_image_path.$productImage->image)){
            unlink($small_image_path.$productImage->image);
        }
        if(file_exists($medium_image_path.$productImage->image)){
            unlink($medium_image_path.$productImage->image);
        }

        Product::where(['id' => $id])->update(['image' => '']);
        Session::flash('danger', 'Product Image Has Been Deleted Successfully');
        return redirect()->back();

    }

    public function getProductPrice(Request $request){
        $data = $request->all();
        $proArr = explode("-", $data['idSize']);
        $proAttr = ProductsAttribute::where(['product_id' => $proArr[0], 'size' => $proArr[1]])->first();
        echo $proAttr->price;
        echo "#";
        echo $proAttr->stock;
    }


    public function addImages(Request $request, $id){
        $productDetails = Product::with('attributes')->where(['id' => $id])->first();
        $productImages = ProductsImage::where(['product_id' => $id])->get();

        if($request->isMethod('post')){
            $data = $request->all();
//            echo "<pre>"; print_r($data); die;
            if($request->hasFile('image')){
                $files = $request->file('image');
                foreach($files as $file){
                    $image = new ProductsImage;
                    $extension = $file->getClientOriginalExtension();
                    $filename = rand(1111,99887878).'.'.$extension;

                    $large_image_path = 'public/adminpanel/uploads/products/large/'.$filename;
                    $medium_image_path = 'public/adminpanel/uploads/products/medium/'.$filename;
                    $small_image_path = 'public/adminpanel/uploads/products/small/'.$filename;

                    Image::make($file)->save($large_image_path);
                    Image::make($file)->resize(600,600)->save($medium_image_path);
                    Image::make($file)->resize(300,300)->save($small_image_path);

                    $image->image = $filename;
                    $image->product_id = $data['product_id'];
                    $image->save();
                }
            }
            Session::flash('success', "Product Image Has Been Succesfully Inserted");
            return redirect()->back();
        }
        return view ('admin.products.add_images', compact('productDetails', 'productImages'));
    }


    public function deleteAltImage($id){
        $productImage = ProductsImage::where('id', $id)->first();

        $large_image_path = 'public/adminpanel/uploads/products/large/';
        $medium_image_path = 'public/adminpanel/uploads/products/medium/';
        $small_image_path = 'public/adminpanel/uploads/products/small/';

        if(file_exists($large_image_path.$productImage->image)){
            unlink($large_image_path.$productImage->image);
        }
        if(file_exists($small_image_path.$productImage->image)){
            unlink($small_image_path.$productImage->image);
        }
        if(file_exists($medium_image_path.$productImage->image)){
            unlink($medium_image_path.$productImage->image);
        }

        ProductsImage::where(['id' => $id])->delete();
        Session::flash('error', 'Product Image Deleted');
        return redirect()->back();
    }


    public function editAttributes(Request $request, $id){
        if($request->isMethod('post')){
            $data = $request->all();
//            echo "<pre>"; print_r($data); die;
            foreach($data['idAttr'] as $key => $attr){
                ProductsAttribute::where(['id' => $data['idAttr'][$key]])->update(['price' => $data['price'][$key], 'stock' => $data['stock'][$key]]);
            }
            Session::flash('success', 'Product Attribute Updated');
            return redirect()->back();
        }
    }
}
