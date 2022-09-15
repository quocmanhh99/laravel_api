<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">

    <title>Demo Restful Api</title>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-12 mt-5">
                <h1 class="text-center">Demo Restful Api</h1>
                <div class="list-group" id='list-products'>
                </div>
                <form action="" method="post" class="mt-5 mb-5" id='formAdd'>
                    @csrf
                    <p class="text-center">Form Thêm mới</p>
                    <div class="form-group" id='product_name_group'>
                        <label for="">Tên sản phẩm</label>
                        <input type="text" class="form-control" name="product_name">

                    </div>
                    <div class="form-group" id='product_status_group'>
                        <div class="radio">
                            <label for="">Trạng thái</label>
                            <input type="radio" name="product_status" value="1">
                            Hiển thị
                            <input type="radio" name="product_status" value="0">
                            Ẩn
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.20/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"
        integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <script>
        function log(value){
    console.log(value)
}
        // const productApi ;
        const listProduct = document.querySelector('#list-products');
        log(listProduct)

        function load_data() {
            // fetch('http://localhost/Laravel-8/api/demo/restfulapi/productAjax')
            //     .then((response) => response.json())
            //     .then((data) => listProduct.innerHTML = data);
            $.get('http://localhost/Laravel-8/api/demo/restfulapi/productAjax', function(res) {
                $('#list-products').html(res);
            })
        }
        load_data()

        $('#formAdd').on('submit', function(e) {
            $(".form-group").removeClass("has-error");
            $(".help-block").remove();
            e.preventDefault();
            let formData = $('#formAdd').serialize();
            // fetch('https://quocmanh.com/Laravel-8/api/demo/restfulapi/addProduct', {
            //         method: 'POST', // or 'PUT'
            //         headers: {
            //             'Content-Type': 'application/json',
            //         },
            //         body: JSON.stringify(formData),
            //     })
            //     .then((response) => response.json())
            //     .then((data) => {
            //         console.log('Success:', data);
            //     })
            //     .catch((error) => {
            //         console.error('Error:', error);
            //     });
            $.post('http://localhost/Laravel-8/api/demo/restfulapi/addProduct', formData, function(res) {
                // console.log(res)
                if (res.status_code == 405) {
                    let html = '';
                    // console.log(res)
                    // console.log(res.data)
                    $.each(res.data, function(field_name, error) {
                        // console.log(field_name)
                        $("#" + field_name + "_group").addClass("has-error");
                        $("#" + field_name + "_group").append(
                            '<div class="help-block" style="color:red">' +
                            error +
                            "</div>"
                        );
                        // $("#" + field_name + "_error").text(error);
                        // $('.alert-danger').show();
                        // $('.alert-danger').append('<strong><span>' + error +
                        //     '</span></strong> <br>');
                    })
                    res.errors.forEach(err => {
                        html += '<li>' + err + '</li>'
                    });

                    Swal.fire({
                        title: res.message,
                        html: html,
                        icon: 'error',
                        confirmButtonText: 'Thoát'
                    })
                } else {
                    toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": true,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    }
                    toastr.success('Thêm mới sản phẩm thành công !')
                    Swal.fire({
                        title: 'Success !',
                        text: res.message,
                        icon: 'success',
                        confirmButtonText: 'Thoát'
                    })
                    load_data()
                }
            })
        })

        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            let href = $(this).attr('href');
            let data = {
                _token: '{{ csrf_field() }}',
                method: 'DELETE'
            }
            if (confirm('Bạn có chắc xóa bản ghi này hay không ?')) {
                $.post(href, data, function(res) {
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
                })
            }
        })
    </script>
</body>

</html>
