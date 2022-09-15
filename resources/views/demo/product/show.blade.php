@extends('layouts.shop')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            @if (session('status'))
            <div class="alert alert-success text-center">
                {{ session('status') }}
            </div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger text-center">
                {{ session('error') }}
            </div>
            @endif
            <h1>Shop</h1>
            <div class="list-product mt-3">
                <div class="row">
                    @foreach ( $products as $product)
                    <div class="col-md-3 col-sm-4 col-6 mb-3">
                        <div class="product-item border py-2">
                            <div class="product-thumb text-center">
                                <a href="">
                                    <img class="img-fluid t" src="{{ Avatar::create($product->product_name)->toBase64() }}" alt="">
                                </a>
                            </div>
                            <div class="product-info p-2 text-center">
                                <a class="product-title" href="">{{ $product->product_name }}</a>
                                <div class="price-box">
                                    <span class="current-price text-danger">{{ number_format($product->product_price_new,0,'','.') }} đ</span>
                                    <span class="old-price text-muted">{{ number_format($product->product_price_old,0,'','.') }} đ</span>
                                </div>
                                <a href="{{ route('demo.cart.add',$product->product_id) }}" class="btn btn-outline-danger btn-sm mt-3" class="add-to-cart">Đặt Mua</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="col-12">
                        {{$products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
