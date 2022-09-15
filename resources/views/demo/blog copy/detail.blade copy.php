@extends('layouts.admin')
@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
                <textarea name="" id="" cols="10" rows="5" name="content" class="form-control" placeholder="Nhập bình luận"></textarea> <br> <hr>
                <input type="submit" class="btn btn-secondary" value="Submit">
            </div>
        </form>
        <h3>Các bình luận:</h3>
        <div class="comment">
            <div class="media">
                <a href="" class='pull-left mr-2'>
                    <img src="https://banner2.cleanpng.com/20190224/taf/kisspng-portable-network-graphics-vector-graphics-clip-art-do-nootropics-work-best-5-supplements-5c72a50c2701f4.0128278115510172281598.jpg" alt=" " class="img-fluid" width="50">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">
                        Nguyễn Huy Hoàng
                    </h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veniam dolore pariatur eos esse, temporibus explicabo beatae magnam earum vel, facere nisi autem quaerat minus, quod sapiente voluptates provident asperiores? Quidem!</p>
                    <p>
                        <a href="" class="btn btn-success">Trả lời</a>
                    </p>
                    <form action="" method="post" >
                        <div class="form-group">
                            <label for="">Nội dung bình luận</label>
                            <input type="hidden" value="{{ $blog->id }}" name='blog_id'>
                            <textarea name="" id="" cols="10" rows="5" name="content" class="form-control" placeholder="Nhập nội dung(*)"></textarea> <br> <hr>
                            <button type="submit" class="btn btn-secondary">
                                Gửi nội dung trả lời
                            </button>
                        </div>
                    </form>
                    {{-- Các bình luận con --}}
                    <div class="media">
                        <a href="" class='pull-left mr-2'>
                            <img src="https://banner2.cleanpng.com/20190224/taf/kisspng-portable-network-graphics-vector-graphics-clip-art-do-nootropics-work-best-5-supplements-5c72a50c2701f4.0128278115510172281598.jpg" alt=" " class="img-fluid" width="50">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading">
                                Nguyễn Huy Hoàng
                            </h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veniam dolore pariatur eos esse, temporibus explicabo beatae magnam earum vel, facere nisi autem quaerat minus, quod sapiente voluptates provident asperiores? Quidem!</p>
                            <p>
                                <a href="" class="btn btn-success">Trả lời</a>
                            </p>
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="">Nội dung bình luận</label>
                                    <input type="hidden" value="{{ $blog->id }}" name='blog_id'>
                                    <textarea name="" id="" cols="10" rows="5" name="content" class="form-control" placeholder="Nhập nội dung(*)"></textarea> <br> <hr>
                                    <button type="submit" class="btn btn-secondary">
                                        Gửi nội dung trả lời
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
