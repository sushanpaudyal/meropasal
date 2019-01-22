<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Product;

class IndexController extends Controller
{
    public function index(){
        $productsAll = Product::latest()->get();
        $categories = Category::with('categories')->where(['parent_id' => 0])->get();
        return view ('frontend.index',compact('productsAll', 'categories'));
    }
}
