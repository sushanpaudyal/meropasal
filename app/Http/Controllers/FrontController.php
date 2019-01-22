<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;

class FrontController extends Controller
{

    public function products($slug = null){

//        Get all the categories and sub categories
        $categories = Category::with('categories')->where(['parent_id' => 0])->get();
        $categoriesDetails = Category::where(['slug' => $slug])->first();

        if($categoriesDetails->parent_id == 0){
//            if slug is main category
            $subCategories = Category::where(['parent_id' => $categoriesDetails->id])->get();
            foreach($subCategories as $subcat){
                $cat_ids[] = $subcat->id;
            }
            $productsAll = Product::whereIn('category_id', $cat_ids)->get();
            $productsAll = json_decode(json_encode($productsAll));
        } else {
//            if slug is subcategory
            $productsAll = Product::where(['category_id' => $categoriesDetails->id])->get();
        }










        return view ('frontend.products.listing', compact('categoriesDetails', 'productsAll', 'categories'));
    }
}
