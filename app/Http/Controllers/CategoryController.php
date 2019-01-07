<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
Use Session;

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
            Session::flash('success', 'Category Has Been Inserted Successfully');
            return redirect()->route('category.view');
        }
        return view ('admin.categories.add_category');
    }

    public function viewCategories(){
        $categories = Category::latest()->get();
        return view ('admin.categories.view_categories', compact('categories'));
    }


    public function editCategory(Request $request, $id = null){
        $category = Category::where(['id' => $id])->first();

        if($request->isMethod('post')){
            $data = $request->all();
            if(empty($data['status'])){
                $data['status'] = "0";
            } else {
                $data['status'] = "1";
            }
            Category::where(['id' => $id])->update(['name' => ucwords(strtolower($data['name'])) , 'parent_id' => $data['parent_id'] , 'description' => $data['description'] , 'slug' => str_slug($data['name']) , 'status' => $data['status']
                ]);
            Session::flash('info', 'Category Has Been Updated');
            return redirect()->route('category.view');
        }
        return view ('admin.categories.edit_category')->with(compact('category'));
    }

    public function deleteCategory($id = null){
        if(!empty($id)){
            Category::where(['id' => $id])->delete();
            Session::flash('danger', 'Category Has Been Permanently Deleted');
            return redirect()->route('category.view');
        }
    }
}
