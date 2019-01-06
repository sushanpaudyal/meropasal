<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function addCategory(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $category = new Category;
            $category->name = ucwords(strtolower($data['name']));
            $category->description = $data['description'];
            $category->slug = str_slug($data['name']);
            if($request->status = "checked"){
                $category->status = "1";
            } else {
                $category->status = "0";
            }
            $category->parent_id = $data['parent_id'];
            $category->save();
            return redirect()->back();
        }
        return view ('admin.categories.add_category');
    }
}
