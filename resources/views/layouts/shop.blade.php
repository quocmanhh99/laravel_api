<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Danh sách sản phẩm</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ url('/') }}/public/demo/cart/css/main.css">
</head>

<body>
    <div id="wraper">
        <div id="header" class="bg-dark mb-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-9  text-white text-bold py-2">
                        <a href=""><img src="{{ Avatar::create('Quốc Mạnh')->toBase64() }}" height='75px'></a>
                    </div>
                    <div class="col-md-3 mt-4 mb-4">
                        <a class="btn btn-primary " href="{{ route('demo.product.show') }}" role="button">Trang chủ</a>
                        <a class="btn btn-primary" href="{{ route('demo.cart.show') }}" role="button">Giỏ hàng<span class="text-white">({{ Cart::count() }})</span></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end header -->
        <div id="wp-content">
            @yield('content')
        </div>
        <!-- end wp-content -->
        <div id="footer" class="bg-secondary text-center text-warning mt-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        Quốc Mạnh
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>
