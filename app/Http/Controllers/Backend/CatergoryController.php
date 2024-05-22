<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\SlugGenerator;
use App\Http\Controllers\Controller;

class CatergoryController extends Controller
{

    use SlugGenerator;


    function category()
    {
        $categories = Category::with('subcategories')->Where('category_id',null)->Latest()->paginate(8); //all dile shob chole ashe asc order e  Category::all()
        return view('backend.category',compact('categories'));
    }
    function categoryadd(Request $req,$id=null)
    {
       $slug= $this->createSlug(Category::class,$req->title);
        $category = Category::findOrNew($id);
        $category->title=$req->title;
        $category->category_id=$req->parent_id;
        $category->title_slug=$slug;
        $category->save();
        return redirect('/category');

    }
    function categorydelete($id)
    {
       
        Category::find($id)->delete();
        return back();
    }
    function categoryedit($id)
    {
        $categories = Category::with('subcategories')->Where('category_id',null)->Latest()->paginate(8); //all dile shob chole ashe asc order e  Category::all()   //Category::Latest()->get()
        $foundcategory=Category::find($id);
        return view('backend.category',compact('foundcategory','categories'));
        
    }
}
