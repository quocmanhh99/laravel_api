<?php

namespace App\Http\Controllers\Demo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DemoCalculateController extends Controller
{
    public function index(){
        return view('demo.calculate.index');
    }

    public function store(Request $request){
        $data = $request->all();
        $numberOrder = $request->number_order;
        $price = $request->price;
        $total = $price * $numberOrder;

        return response()->json(['status' => 'true', 'data' => $data,'numberOrder'=>$numberOrder,'price'=> $price,'total'=>$total]);
    }
}
