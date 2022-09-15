<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel load more page scroll</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <style>
        .wrapper>ul#results li {
            margin-bottom: 2px;
            background: #e2e2e2;
            padding: 20px;
            width: 97%;
            list-style: none;
        }

        .ajax-loading {
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="wrapper">
            <ul id="results">
                <!-- results appear here -->
            </ul>
            <div class="ajax-loading"><img src="{{ asset('images/loading.gif') }}" /></div>
        </div>
    </div>
</body>

</html>
<script>
    var SITEURL = "{{ url('/') }}";
    var page = 1; //track user scroll as page number, right now page number is 1
    load_more(page); //initial content load
    $(window).scroll(function() { //detect page scroll
        if ($(window).scrollTop() + $(window).height() >= $(document)
        .height()) { //if user scrolled from top to bottom of the page
            page++; //page number increment
            load_more(page); //load content
        }
    });

    function load_more(page) {
        $.ajax({
                url: SITEURL + "/projectv1/admin/user/load-more?page=" + page,
                type: "get",
                datatype: "html",
                beforeSend: function() {
                    $('.ajax-loading').show();
                }
            })
            .done(function(data) {
                if (data.length == 0) {
                    //notify user if nothing to load
                    $('.ajax-loading').html("Chúng tôi không có thêm dữ liệu để hiển thị :(");
                    return;
                }
                $('.ajax-loading').hide(); //hide loading animation once data is received
                $("#results").append(data); //append data into #results element
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                alert('Đã xảy ra lỗi máy chủ');
            });
    }
</script>
