@extends('layouts.shop')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form>
                    @if (session('status'))
                        <div class="alert alert-success text-center">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h1>Giỏ hàng</h1>
                    <p>
                        Hiện tại có <span id='count'></span> sản phẩm trong giỏ hàng
                    </p>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Ảnh</th>
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col">Giá</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Thành tiền</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody id="cartPage">
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan='6' class="text-right">Tổng:</td>
                                <td><strong>{{ Cart::total() }} đ</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                    <input class="btn btn-primary" type="submit" value="Cập nhật giỏ hàng">
                    <a class="btn btn-primary " href="{{ route('demo.cart.destroy') }}" role="button">Xóa giỏ hàng</a>

                </form>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            $(function(){
                $('.num-cart').click(function(){
                    alert('Bạn đã click vào thẻ này');
                });
            });
            </script>
    <script>
        function cart() {
            $.ajax({
                type: 'GET',
                url: "{{ route('demo.cart.getCart') }}",
                dataType: 'json',
                success: function(response) {

                    var rows = ""
                    var i = 1;
                    $('#count').html(response.count);
                    $.each(response.data, function(key, value) {
                        var img = "{{ Avatar::create('v')->toBase64() }}"
                        rows += `<tr>
                                <td >${i++}</td>
        <td><img src="${img} " alt="imga" style="width:60px; height:60px;"></td>
        <td>${value.name}</td>
        <td>${value.price} đ</td>
        <td class="col-md-2">


        <input type="number" value="${value.qty}" min="1" max="100" class='num-cart' data-id="${value.rowId}" style="width:50px;"   onclick="cartUpdate()">

            </td>
             <td class="col-md-2">
            <strong>${value.subtotal} đ </strong>
            </td>
            <td class="col-md-1 close-btn">
            <button type="submit" class="btn btn-success" id="${value.rowId}" onclick="cartRemove(this.id)">Xóa</button>
        </td>
                </tr>`
                    });

                    $('#cartPage').html(rows);
                }
            })
        }
        cart();


        function cartUpdate() {
            var qty = $('.num-cart').val();
            var rowId = $('.num-cart').attr('data-id');
            var data = {
                "_token": "{{ csrf_token() }}",
                rowId: rowId,
                qty: qty
            }
            console.log(data)
            $.ajax({
                type: 'POST',
                url: "{{ route('demo.cart.update') }}",
                data: data,
                dataType: 'json',
                success: function(data) {
                    $('#count').html(data.count);
                    cart();
                    location.reload();
                }
            });
        }
    </script>

@endsection
