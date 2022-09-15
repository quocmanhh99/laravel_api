<?php

namespace App\Http\Controllers\Demo\Prodcut;

use App\Http\Controllers\Controller;
use App\Models\Demo\Product\DemoProduct;
use Illuminate\Http\Request;

class DemoProductController extends Controller
{
    public function show(){
        $products = DemoProduct::paginate(8);
        return view('demo.product.show',compact('products'));
    }
}
