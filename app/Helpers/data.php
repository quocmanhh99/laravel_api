<?php

use App\Models\Demo\DemoGroup;
use App\Models\Demo\Product\DemoProduct;

function getAllGroups()
{
    $groups = new DemoGroup();
    return $groups->getAll();
}

function add_cart_product($id)
{
    $product = DemoProduct::where('product_id', $id)->first();
    $qty = 1;

    if (isset($_SESSION['cart']) && array_key_exists($id, $_SESSION['cart']['buy'])) {
        $qty = $_SESSION['cart']['buy'][$id]['qty'] + 1;
    };

    $_SESSION['cart']['buy'][$id] = array(
        'id' => $product->product_id,
        'name' => $product->product_name,
        'qty' => $qty,
        'price' => $product->product_price_new,
        'image' =>  $product->product_image,
        'sub_total' => $product->product_price_new * $qty
    );
}
