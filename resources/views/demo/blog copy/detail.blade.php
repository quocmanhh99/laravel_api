@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="jumbotron ">
                    <h1 class="display-4">{{ $blog->name }}</h1>
                    <img src="{{ $blog->image }}" alt="" class="img-fluid h-25 m-auto">
                    <hr class="my-4">
                    <p>{!! $blog->content !!}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <h3>Bình luận bài viết này:</h3>
        <form action="" method="post">
            <div class="form-group">
                <label for="">Nội dung bình luận</label>
                <input type="hidden" value="{{ $blog->id }}" name='blog_id'>
                <textarea name="content" id="comment-content" cols="10" rows="5" class="form-control"
                    placeholder="Nhập bình luận (*)"></textarea> <br>
                    <small id='comment-error' class="help-blog" style="color: red">

                    </small>
                <hr>
                <button type="button" class="btn btn-success" id='btn-comment'>
                    Gửi bình luận
                </button>
            </div>
        </form>
        <h3>Các bình luận:</h3>
        <div id="comment">
            @foreach (  $blog->comments  as $comm)
<div class="media">
    <a href="" class='pull-left mr-2'>
        <img src="https://banner2.cleanpng.com/20190224/taf/kisspng-portable-network-graphics-vector-graphics-clip-art-do-nootropics-work-best-5-supplements-5c72a50c2701f4.0128278115510172281598.jpg"
            alt=" " class="img-fluid" width="50">
    </a>
    <div class="media-body">
        <h4 class="media-heading">
            {{ $comm->cus->name }}
        </h4>
        <p>{{ $comm->content }}</p>
        <p>
            <a href="" class="btn btn-success">Trả lời</a>
        </p>
        <form action="" method="post" style="display: none">
            <div class="form-group">
                <label for="">Nội dung bình luận</label>
                <input type="hidden" value="" name='blog_id'>
                <textarea name="" id="" cols="10" rows="5" name="content" class="form-control"
                    placeholder="Nhập nội dung(*)"></textarea> <br>
                <hr>
                <button type="submit" class="btn btn-secondary">
                    Gửi nội dung trả lời
                </button>
            </div>
        </form>
        {{-- Các bình luận con --}}
        @foreach ( $comm->replies as $child)
        <div class="media">
            <a href="" class='pull-left mr-2'>
                <img src="https://banner2.cleanpng.com/20190224/taf/kisspng-portable-network-graphics-vector-graphics-clip-art-do-nootropics-work-best-5-supplements-5c72a50c2701f4.0128278115510172281598.jpg"
                    alt=" " class="img-fluid" width="50">
            </a>
            <div class="media-body">
                <h4 class="media-heading">
                    {{ $child->cus->name }}
                </h4>
                <p>{{ $child->content }}</p>
                    <a href="" class="btn btn-success">Trả lời</a>
                </p>
                <form action="" method="post" style="display: none">
                    <div class="form-group">
                        <label for="">Nội dung bình luận</label>
                        <input type="hidden" value="" name='blog_id'>
                        <textarea name="" id="" cols="10" rows="5" name="content" class="form-control"
                            placeholder="Nhập nội dung(*)"></textarea> <br>
                        <hr>
                        <button type="submit" class="btn btn-secondary">
                            Gửi nội dung trả lời
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endforeach

    </div>
</div>
@endforeach


        </div>

    </div>
    <script>
        $(document).ready(function() {
            $('#btn-comment').click(function(ev) {
                ev.preventDefault();
                let content = $('#comment-content').val();
                let commentUrl = "{{ route('demo.admin.blog.comment', $blog->id) }}";

                $.ajax({
                    url: commentUrl,
                    type: 'POST',
                    data : {
                        content: content,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res){
                        if(res.error){
                            $('#comment-error').html(res.error)
                        }else{
                            $('#comment-error').html('');
                            $('#comment-content').val('');
                            $('#comment').html(res);
                        }
                    }
                })
            })
        });
    </script>
@endsection

