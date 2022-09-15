<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Demo Ajax Calculate</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mt-5">Demo Ajax Calculate</h1>
                <div class="mb-3">
                    <form action="">
                        <p>
                            Giá: <span id='price'>10</span>
                        </p>
                        <label for="num_order" class="form-label">Số lượng: </label>
                        <input type="number" min='0' max='10' class="form-control" id="num_order" >
                        <hr>
                        <p>
                            Tổng: <span id='total'></span>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <script>
        $(document).ready(function(){
            $("#num_order").change(function(){
                var num_order = $('#num_order').val();
                var price = $('#price').text();
                var data = {"_token": "{{ csrf_token() }}",price:price,number_order:num_order}
                $.ajax({
                    url: "{{ route('demo.calculate.store') }}",
                    // Trang xử lý, mặc định trang hiện tại
                    method: "POST",
                    // POST or GET , mặc định GET
                    data: data,
                    // Dữ liệu từ form truyền lên serve
                    dataType: 'JSON',
                    // html,text,script,json
                    success: function(data){
                        // Xử lý dữ liệu trả về
                        // console.log(data.total)
                        // $('#total').text(data.total);
                        $('#total').html("<b>"+data.total+"</b>")
                    }
                })
            })
        })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>
