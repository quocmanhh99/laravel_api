<!-- Modal -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<div class="modal-container" id="modal-container">
</div>
<div class="modal fade" id="ajax-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="userShowModal"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="mt-5 mb-5" id='formEdit'>
                    @csrf
                    <input type="hidden" name="product_id" id="product_id">
                    <p class="text-center">Form sửa</p>
                    <div class="form-group">
                        <label for="">Tên sản phẩm</label>
                        <input type="text" class="form-control" name="product_name" id='product_name'>
                        <span class="text-danger" id="name-error"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Mã sản phẩm</label>
                        <input type="text" class="form-control" name="product_code" id='product_code'>
                        <span class="text-danger" id="code-error"></span>
                    </div>
                    <div class="form-group">
                        <div class="radio">
                            <label for="">Trạng thái</label>
                            <input type="radio" name="product_status" class="" value="1" checked>
                            Hiển thị
                            <input type="radio" name="product_status" value="0">
                            Ẩn
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                <button type="submit" class="btn btn-primary" id="btn-save" value="addNewBook">Lưu
                </button>
            </div>
        </div>
    </div>
</div>
<table class="table table-bordered border-primary">
    <thead>
        <tr>
            <th scope="col"><a href=""></a> </b></th>
            <th scope="col">ID <i class="fa-solid fa-arrow-down-arrow-up"></i></th>
            <th scope="col"><a href="?sort=product_name&by=desc" class="link">Name</a></th>
            <th scope="col">Status <i class="fa-solid fa-arrow-down-arrow-up"></i></th>
            <th>Quản lý</th>
        </tr>
    </thead>
    <tbody>
        @php
            $t = 0;
        @endphp
        @foreach ($products as $product)
            @php
                $t++;
            @endphp
            <tr>
                <th scope="row">{{ $t }} </th>
                <td>{{ $product->product_id }}</td>
                <td>{{ $product->product_name }}</td>
                <td>{{ $product->product_status == 0 ? 'Ẩn' : 'Hiển thị' }}</td>
                <td>
                    <a href="javascript:void(0)" class="btn btn-sm btn-primary mb-2" data-bs-toggle="modal"
                        data-bs-target="#exampleModal" id="show-user" data-id="{{ $product->product_id }}">Sửa</a>
                    <br>
                    <a href="javascript:void(0)" class="btn btn-sm btn-primary delete mb-2"
                        data-id="{{ $product->product_id }}">Xóa</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    const link = doc
    $(document).ready(function(){
        $('body').on('click', '.link', function() {
            e.preventdefault();
            var d = $("[name='frm1']").serialize();
            $.ajax({
                url:"xuly.php",
                data:d,
                type:'post',
                cache:false,
                success:function(data) { $("#kq").html(data);}
            });
        });
    });
</script>
<script>
    $('body').on('click', '.delete', function() {
        if (confirm('Bạn có chắc xóa bản ghi này hay không ?')) {
            var id = $(this).data('id');

            // ajax
            $.ajax({
                type: "POST",
                url: "{{ url('/') }}/api/demo/restfulapi/deleteProduct/" + id,
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    if (res.status_code == 200) {
                        load_data();
                        Swal.fire({
                            title: 'Success !',
                            text: res.message,
                            icon: 'success',
                            confirmButtonText: 'Thoát'
                        })
                    } else {
                        Swal.fire({
                            title: 'Error !',
                            text: res.message,
                            icon: 'error',
                            confirmButtonText: 'Thoát'
                        })
                    }
                }
            });
        }
    });

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('body').on('click', '#show-user', function() {
            var id = $(this).data('id');

            // ajax
            $.ajax({
                type: "GET",
                url: "" + id,
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    $('#userShowModal').html("Demo RestfulApi Sửa");
                    $('#ajax-modal').modal('show');
                    $('#product_id').val(res.data.product_id);
                    $('#product_name').val(res.data.product_name);
                    $('#product_code').val(res.data.product_code);

                    // $('#updateProduct').html(update);
                    // $('#email').val(data.email);
                }
            });
        });


    });


    $('body').on('click', '#btn-save', function(event) {
        var product_id = $("#product_id").val();
        var product_name = $("#product_name").val();
        var product_status = $("input[name='product_status']").val();
        var product_code = $("#product_code").val();
        $('#name-error').text('');
        $('#code-error').text('');

        // ajax
        $.ajax({
            type: "POST",
            url: "{{ route('demo.restfulapi.updateProduct') }}",
            data: {
                product_id: product_id,
                product_name: product_name,
                product_status: product_status,
                product_code: product_code,
            },
            dataType: 'json',
            success: function(res) {
                if (res.status_code == 405) {
                    $('#name-error').text(res.errors.product_name);
                    $('#code-error').text(res.errors.product_code);
                } else {
                    toastr.options.preventDuplicates = true;
                    toastr.success('Sửa sản phẩm thành công !')
                    $('#ajax-modal').modal('hide');
                    load_data();
                }
            },
            error: function(res) {
                $('#name-error').text(res.errors.product_name);
                    $('#code-error').text(res.errors.product_code);
            }
        });
    })
</script>
