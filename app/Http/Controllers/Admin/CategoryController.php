<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function add(){
        $category_product = $this->getCategoriesProduct();
        return view('admin.category.add',compact('category_product'));
    }

    public function getCategoriesProduct(){
        $categories = Category::where('status',0)->get();
        return Category::recursive($categories,0);
    }
}
