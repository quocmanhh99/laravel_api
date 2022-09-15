<?php

namespace App\Http\Controllers\Demo\Cart;

use App\Http\Controllers\Controller;
use App\Models\Demo\Product\DemoProduct;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class DemoCartController extends Controller
{
    public function show()
    {
        return view('demo.cart.show');
    }

    public function __construct()
    {
        session_start();
    }

    public function getCart()
    {
        $cart = Cart::content();
        $count = Cart::count();
        return response()->json(['data' => $cart, 'count' => $count]);
    }
    public function add($id, Request $request)
    {
        $product = DemoProduct::where('product_id', $id)->first();

        $qty = 1;

        if (isset($_SESSION['cart']) && array_key_exists($id, $_SESSION['cart']['buy'])) {
            $qty = $_SESSION['cart']['buy'][$id]['qty'] + 1;
        };

        $_SESSION['cart']['buy'][$id] = array(
            'id' => $product->product_id,
            'name' => $product->product_name,
            'qty' => 1,
            'price' => $product->product_price_new,
            'image' =>  $product->product_image,
            'sub_total' => $product->product_price_new * $qty
        );

        return  $_SESSION['cart'];

        $request->session()->put('key', 'value');
        $product = DemoProduct::where('product_id', $id)->first();
        if ($product) {
            Cart::add([
                'id' => $product->product_id,
                'name' => $product->product_name,
                'qty' => 1,
                'price' => $product->product_price_new,
                'options' => ['image' =>  $product->product_image],
            ]);
            return redirect()->route('demo.cart.show')->with('status', 'Thêm sản phẩm vào giỏ hàng thành công');
        } else {
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại !');
        }
    }

    public function remove($rowId)
    {
        Cart::remove($rowId);
        return redirect()->route('demo.cart.show')->with('status', 'Xóa sản phẩm thành công');
    }

    public function destroy()
    {
        Cart::destroy();
        return redirect()->route('demo.cart.show')->with('status', 'Xóa giỏ hàng thành công');
    }

    public function update(Request $request)
    {
        $rowId = $request->rowId;
        $qty = $request->qty;
        Cart::update($rowId, $qty);
        $total = Cart::total();
        $cart = Cart::content();
        $count = Cart::count();
        return response()->json(['status' => 'true', 'total' => $total, 'cart' => $cart, 'count' => $count]);
    }
}
