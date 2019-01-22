<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function products($slug = null){
        $categories = Category::with('categories')->where(['parent_id' => 0])->get();
        $categoryDetails = Category::where(['slug' => $slug])->first();
        $products = Product::where(['category_id' => $categoryDetails->id])->get();
        return view ('frontend.products.listing', compact('categoryDetails', 'categories', 'products'));
    }
}
