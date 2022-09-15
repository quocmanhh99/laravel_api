@foreach (  $comments  as $comm)
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

