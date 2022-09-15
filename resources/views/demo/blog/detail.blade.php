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
            @foreach (  $comments  as $key => $comm)

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
                        <a href="" class="btn btn-success btn-show-reply-form"  data-id="{{ $comm->id }}">Trả lời</a>
                    </p>
                    <form action="" method="post" style="display: none" class="formReply form-reply-{{ $comm->id }}">
                        <div class="form-group">
                            <label for="">Nội dung bình luận</label>
                            <input type="hidden" value="" name='blog_id'>
                            <textarea id="content-reply-{{ $comm->id }}" cols="10" rows="5" name="content-reply" class="form-control"
                                placeholder="Nhập nội dung(*)"></textarea> <br>
                            <hr>
                            <button type="submit" class="btn btn-secondary btn-send-comment-reply" data-id="{{ $comm->id }}">
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
                            <a href="" class="btn btn-success btn-show-reply-form"  data-id="{{ $child->id }}">Trả lời</a>
                            </p>
                            <form action="" method="post" style="display: none" class="formReply form-reply-{{ $child->id }}">
                                <div class="form-group">
                                    <label for="">Nội dung bình luận</label>
                                    <input type="hidden" value="" name='blog_id'>
                                    <textarea id="content-reply-{{ $child->id }}" cols="10" rows="5" name="content-reply" class="form-control"
                                        placeholder="Nhập nội dung(*)"></textarea> <br>
                                    <hr>
                                    <button type="submit" class="btn btn-secondary btn-send-comment-reply" data-id="{{ $child->id }}">
                                        Gửi nội dung trả lời
                                    </button>
                                </div>
                            </form>
                            @foreach ( $child->replies as $child1)

                            <div class="media">
                                <a href="" class='pull-left mr-2'>
                                    <img src="https://banner2.cleanpng.com/20190224/taf/kisspng-portable-network-graphics-vector-graphics-clip-art-do-nootropics-work-best-5-supplements-5c72a50c2701f4.0128278115510172281598.jpg"
                                        alt=" " class="img-fluid" width="50">
                                </a>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        {{ $child1->cus->name }}
                                    </h4>
                                    <p>{{ $child1->content }}</p>
                                    <a href="" class="btn btn-success btn-show-reply-form"  data-id="{{ $child1->id }}">Trả lời</a>
                                    </p>
                                    <form action="" method="post" style="display: none" class="formReply form-reply-{{ $child1->id }}">
                                        <div class="form-group">
                                            <label for="">Nội dung bình luận</label>
                                            <input type="hidden" value="" name='blog_id'>
                                            <textarea id="content-reply-{{ $child1->id }}" cols="10" rows="5" name="content-reply" class="form-control"
                                                placeholder="Nhập nội dung(*)"></textarea> <br>
                                            <hr>
                                            <button type="submit" class="btn btn-secondary btn-send-comment-reply" data-id="{{ $child1->id }}">
                                                Gửi nội dung trả lời
                                            </button>
                                        </div>
                                    </form>
                                    @foreach ( $child1->replies as $child2)

                                    <div class="media">
                                        <a href="" class='pull-left mr-2'>
                                            <img src="https://banner2.cleanpng.com/20190224/taf/kisspng-portable-network-graphics-vector-graphics-clip-art-do-nootropics-work-best-5-supplements-5c72a50c2701f4.0128278115510172281598.jpg"
                                                alt=" " class="img-fluid" width="50">
                                        </a>
                                        <div class="media-body">
                                            <h4 class="media-heading">
                                                {{ $child2->cus->name }}
                                            </h4>
                                            <p>{{ $child2->content }}</p>
                                            <a href="" class="btn btn-success btn-show-reply-form"  data-id="{{ $child2->id }}">Trả lời</a>
                                            </p>
                                            <form action="" method="post" style="display: none" class="formReply form-reply-{{ $child2->id }}">
                                                <div class="form-group">
                                                    <label for="">Nội dung bình luận</label>
                                                    <input type="hidden" value="" name='blog_id'>
                                                    <textarea id="content-reply-{{ $child2->id }}" cols="10" rows="5" name="content-reply" class="form-control"
                                                        placeholder="Nhập nội dung(*)"></textarea> <br>
                                                    <hr>
                                                    <button type="submit" class="btn btn-secondary btn-send-comment-reply" data-id="{{ $child2->id }}">
                                                        Gửi nội dung trả lời
                                                    </button>
                                                </div>
                                            </form>
                                            @foreach ( $child2->replies as $child3)

                                            <div class="media">
                                                <a href="" class='pull-left mr-2'>
                                                    <img src="https://banner2.cleanpng.com/20190224/taf/kisspng-portable-network-graphics-vector-graphics-clip-art-do-nootropics-work-best-5-supplements-5c72a50c2701f4.0128278115510172281598.jpg"
                                                        alt=" " class="img-fluid" width="50">
                                                </a>
                                                <div class="media-body">
                                                    <h4 class="media-heading">
                                                        {{ $child3->cus->name }}
                                                    </h4>
                                                    <p>{{ $child3->content }}</p>
                                                    <a href="" class="btn btn-success btn-show-reply-form"  data-id="{{ $child3->id }}">Trả lời</a>
                                                    </p>
                                                    <form action="" method="post" style="display: none" class="formReply form-reply-{{ $child3->id }}">
                                                        <div class="form-group">
                                                            <label for="">Nội dung bình luận</label>
                                                            <input type="hidden" value="" name='blog_id'>
                                                            <textarea id="content-reply-{{ $child3->id }}" cols="10" rows="5" name="content-reply" class="form-control"
                                                                placeholder="Nhập nội dung(*)"></textarea> <br>
                                                            <hr>
                                                            <button type="submit" class="btn btn-secondary btn-send-comment-reply" data-id="{{ $child3->id }}">
                                                                Gửi nội dung trả lời
                                                            </button>
                                                        </div>
                                                    </form>
                                                    @foreach ( $child3->replies as $child4)

                                                    <div class="media">
                                                        <a href="" class='pull-left mr-2'>
                                                            <img src="https://banner2.cleanpng.com/20190224/taf/kisspng-portable-network-graphics-vector-graphics-clip-art-do-nootropics-work-best-5-supplements-5c72a50c2701f4.0128278115510172281598.jpg"
                                                                alt=" " class="img-fluid" width="50">
                                                        </a>
                                                        <div class="media-body">
                                                            <h4 class="media-heading">
                                                                {{ $child4->cus->name }}
                                                            </h4>
                                                            <p>{{ $child4->content }}</p>
                                                            <a href="" class="btn btn-success btn-show-reply-form"  data-id="{{ $child4->id }}">Trả lời</a>
                                                            </p>
                                                            <form action="" method="post" style="display: none" class="formReply form-reply-{{ $child4->id }}">
                                                                <div class="form-group">
                                                                    <label for="">Nội dung bình luận</label>
                                                                    <input type="hidden" value="" name='blog_id'>
                                                                    <textarea id="content-reply-{{ $child4->id }}" cols="10" rows="5" name="content-reply" class="form-control"
                                                                        placeholder="Nhập nội dung(*)"></textarea> <br>
                                                                    <hr>
                                                                    <button type="submit" class="btn btn-secondary btn-send-comment-reply" data-id="{{ $child4->id }}">
                                                                        Gửi nội dung trả lời
                                                                    </button>
                                                                </div>
                                                            </form>
                                                            @foreach ( $child4->replies as $child5)

                                                    <div class="media">
                                                        <a href="" class='pull-left mr-2'>
                                                            <img src="https://banner2.cleanpng.com/20190224/taf/kisspng-portable-network-graphics-vector-graphics-clip-art-do-nootropics-work-best-5-supplements-5c72a50c2701f4.0128278115510172281598.jpg"
                                                                alt=" " class="img-fluid" width="50">
                                                        </a>
                                                        <div class="media-body">
                                                            <h4 class="media-heading">
                                                                {{ $child5->cus->name }}
                                                            </h4>
                                                            <p>{{ $child5->content }}</p>
                                                            <a href="" class="btn btn-success btn-show-reply-form"  data-id="{{ $child5->id }}">Trả lời</a>
                                                            </p>
                                                            <form action="" method="post" style="display: none" class="formReply form-reply-{{ $child5->id }}">
                                                                <div class="form-group">
                                                                    <label for="">Nội dung bình luận</label>
                                                                    <input type="hidden" value="" name='blog_id'>
                                                                    <textarea id="content-reply-{{ $child5->id }}" cols="10" rows="5" name="content-reply" class="form-control"
                                                                        placeholder="Nhập nội dung(*)"></textarea> <br>
                                                                    <hr>
                                                                    <button type="submit" class="btn btn-secondary btn-send-comment-reply" data-id="{{ $child5->id }}">
                                                                        Gửi nội dung trả lời
                                                                    </button>
                                                                </div>
                                                            </form>
                                                            @foreach ( $child5->replies as $child6)

                                                            <div class="media">
                                                                <a href="" class='pull-left mr-2'>
                                                                    <img src="https://banner2.cleanpng.com/20190224/taf/kisspng-portable-network-graphics-vector-graphics-clip-art-do-nootropics-work-best-5-supplements-5c72a50c2701f4.0128278115510172281598.jpg"
                                                                        alt=" " class="img-fluid" width="50">
                                                                </a>
                                                                <div class="media-body">
                                                                    <h4 class="media-heading">
                                                                        {{ $child6->cus->name }}
                                                                    </h4>
                                                                    <p>{{ $child6->content }}</p>
                                                                    <a href="" class="btn btn-success btn-show-reply-form"  data-id="{{ $child6->id }}">Trả lời</a>
                                                                    </p>
                                                                    <form action="" method="post" style="display: none" class="formReply form-reply-{{ $child6->id }}">
                                                                        <div class="form-group">
                                                                            <label for="">Nội dung bình luận</label>
                                                                            <input type="hidden" value="" name='blog_id'>
                                                                            <textarea id="content-reply-{{ $child6->id }}" cols="10" rows="5" name="content-reply" class="form-control"
                                                                                placeholder="Nhập nội dung(*)"></textarea> <br>
                                                                            <hr>
                                                                            <button type="submit" class="btn btn-secondary btn-send-comment-reply" data-id="{{ $child6->id }}">
                                                                                Gửi nội dung trả lời
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                    @foreach ( $child6->replies as $child7)

                                                                                    <div class="media">
                                                                                        <a href="" class='pull-left mr-2'>
                                                                                            <img src="https://banner2.cleanpng.com/20190224/taf/kisspng-portable-network-graphics-vector-graphics-clip-art-do-nootropics-work-best-5-supplements-5c72a50c2701f4.0128278115510172281598.jpg"
                                                                                                alt=" " class="img-fluid" width="50">
                                                                                        </a>
                                                                                        <div class="media-body">
                                                                                            <h4 class="media-heading">
                                                                                                {{ $child7->cus->name }}
                                                                                            </h4>
                                                                                            <p>{{ $child7->content }}</p>
                                                                                            <a href="" class="btn btn-success btn-show-reply-form"  data-id="{{ $child7->id }}">Trả lời</a>
                                                                                            </p>
                                                                                            <form action="" method="post" style="display: none" class="formReply form-reply-{{ $child7->id }}">
                                                                                                <div class="form-group">
                                                                                                    <label for="">Nội dung bình luận</label>
                                                                                                    <input type="hidden" value="" name='blog_id'>
                                                                                                    <textarea id="content-reply-{{ $child7->id }}" cols="10" rows="5" name="content-reply" class="form-control"
                                                                                                        placeholder="Nhập nội dung(*)"></textarea> <br>
                                                                                                    <hr>
                                                                                                    <button type="submit" class="btn btn-secondary btn-send-comment-reply" data-id="{{ $child7->id }}">
                                                                                                        Gửi nội dung trả lời
                                                                                                    </button>
                                                                                                </div>
                                                                                            </form>
                                                                                            @foreach ( $child7->replies as $child8)

                                                                                    <div class="media">
                                                                                        <a href="" class='pull-left mr-2'>
                                                                                            <img src="https://banner2.cleanpng.com/20190224/taf/kisspng-portable-network-graphics-vector-graphics-clip-art-do-nootropics-work-best-5-supplements-5c72a50c2701f4.0128278115510172281598.jpg"
                                                                                                alt=" " class="img-fluid" width="50">
                                                                                        </a>
                                                                                        <div class="media-body">
                                                                                            <h4 class="media-heading">
                                                                                                {{ $child8->cus->name }}
                                                                                            </h4>
                                                                                            <p>{{ $child8->content }}</p>
                                                                                            {{-- <a href="" class="btn btn-success btn-show-reply-form"  data-id="{{ $child8->id }}">Trả lời</a>
                                                                                            </p>
                                                                                            <form action="" method="post" style="display: none" class="formReply form-reply-{{ $child8->id }}">
                                                                                                <div class="form-group">
                                                                                                    <label for="">Nội dung bình luận</label>
                                                                                                    <input type="hidden" value="" name='blog_id'>
                                                                                                    <textarea id="content-reply-{{ $child8->id }}" cols="10" rows="5" name="content-reply" class="form-control"
                                                                                                        placeholder="Nhập nội dung(*)"></textarea> <br>
                                                                                                    <hr>
                                                                                                    <button type="submit" class="btn btn-secondary btn-send-comment-reply" data-id="{{ $child8->id }}">
                                                                                                        Gửi nội dung trả lời
                                                                                                    </button>
                                                                                                </div>
                                                                                            </form> --}}

                                                                                        </div>
                                                                                    </div>
                                                                                    @endforeach

                                                                                        </div>
                                                                                    </div>
                                                                                    @endforeach

                                                                </div>
                                                            </div>
                                                            @endforeach

                                                        </div>
                                                    </div>
                                                    @endforeach
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
            @endforeach




        </div>

    </div>
    <script>
         let commentUrl = "{{ route('demo.admin.blog.comment', $blog->id) }}";
        $(document).ready(function() {
            $('#btn-comment').click(function(ev) {
                ev.preventDefault();
                let content = $('#comment-content').val();

                $.ajax({
                    url: commentUrl,
                    type: 'POST',
                    data: {
                        content: content,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        if (res.error) {
                            $('#comment-error').html(res.error)
                        } else {
                            $('#comment-error').html('');
                            $('#comment-content').val('');
                            $('#comment').html(res);
                        }
                    }
                })
            });

            $(document).on('click','.btn-show-reply-form',function(ev) {
                ev.preventDefault();
                var id = $(this).data('id');
                var comment_reply_id = '#content-reply-'+id;
                var form_reply = '.form-reply-' + id;
                var contentReply = $(comment_reply_id).val();
                $('.formReply').slideUp();
                $(form_reply).slideDown();
            });

            $(document).on('click','.btn-send-comment-reply',function(ev) {
                ev.preventDefault();
                var id = $(this).data('id');
                // alert(id);
                var comment_reply_id = '#content-reply-'+id;
                var contentReply = $(comment_reply_id).val();
                var form_reply = '.form-reply-' + id;
                // alert(contentReply);

                $.ajax({
                    url: commentUrl,
                    type: 'POST',
                    data: {
                        content: contentReply,
                        reply_id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        if (res.error) {
                            $('#comment-error').html(res.error)
                        } else {
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
