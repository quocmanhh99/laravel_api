@extends('layouts.shop')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form>
                    @csrf
                    @if (session('status'))
                        <div class="alert alert-success text-center">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h1>Giỏ hàng</h1>
                    <p>
                        Hiện tại có {{ Cart::count() }} sản phẩm trong giỏ hàng
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
                        <tbody id="bodyData">
                            @if (Cart::count() > 0)
                                @php
                                    $t = 0;
                                @endphp
                                @foreach (Cart::content() as $row)
                                    @php
                                        $t++;
                                    @endphp
                                    <tr>
                                        <td scope="row">{{ $t }}</td>
                                        <td>
                                            <img src="{{ Avatar::create($row->name)->toBase64() }}" width="100px"
                                                alt="">
                                        </td>
                                        <td scope="col"><a href="">{{ $row->name }}</a></td>
                                        <td scope="col">{{ number_format($row->price, 0, '', '.') }} đ</td>
                                        <td scope="col">
                                            <input type="number" min='1' max='5' class='num-order' style="width:50px; text-align: center"
                                                value="{{ $row->qty }}" data-id="{{ $row->rowId }}" >
                                        </td>
                                        <td scope="col">{{ number_format($row->total, 0, '', '.') }} đ</td>
                                        <td><a href="{{ route('demo.cart.remove', $row->rowId) }}"
                                                class="text-danger">Xóa</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6">
                                        <p class="text-center">Không có sản phẩm trong giỏ hàng !</p>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan='6' class="text-right">Tổng:</td>
                                <td><strong id='total'>{{ Cart::total() }} đ</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                    <a class="btn btn-primary " href="{{ route('demo.cart.destroy') }}" role="button">Xóa giỏ hàng</a>

                </form>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"    ></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function(){
            $(".num-order").change(function(){
                var rowId = $(this).attr('data-id');
                var qty = $(this).val();
                var data = {"_token": "{{ csrf_token() }}",rowId :rowId ,qty:qty}
                $.ajax({
                    url: "{{ route('demo.cart.update') }}",
                    // Trang xử lý, mặc định trang hiện tại
                    method: "POST",
                    // POST or GET , mặc định GET
                    data: data,
                    // Dữ liệu từ form truyền lên serve
                    dataType: 'JSON',
                    // html,text,script,json
                    success: function(data){
                        // Xử lý dữ liệu trả về
                        window.location.reload();
                        $('#total').text(data.total+' đ');
                        // $('#total').html("<b>"+data.total+"</b>")
                    }
                })
            })
        })
    </script>
@endsection
