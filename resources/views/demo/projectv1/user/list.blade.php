@extends('layouts.admin')
@section('content')
    <div id="content" class="container">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-content-between">
                <h5 class="m-0">Danh sách thành viên</h5>
                <form action="" method="post">
                    @csrf
                    <div class="form-search form-inline d-flex justify-content-between align-content-between">
                        <input type="text" class="form-control form-search mb-1" placeholder="Tìm kiếm cơ bản"
                            name='keyword' value="{{ request()->keyword }}">
                        <input type="submit" name="btn-search" value="search" class="btn btn-primary">
                    </div>
                </form>
            </div>
            <form action="" method="POST">
                <div class="row ml-2 mt-2">
                    @csrf
                    <div class="col-3">
                        <select class="form-control" name="status" id="">
                            <option value="0">Tất cả trạng thái</option>
                            <option value="active" {{ request()->status == 'active' ? 'selected' : false }}>Kích hoạt
                            </option>
                            <option value="inactive" {{ request()->status == 'inactive' ? 'selected' : false }}>Chưa kích
                                hoạt</option>
                        </select>
                    </div>
                    <div class="col-3">
                        <select class="form-control" name="group_id" id="">
                            <option value="0">Tất cả nhóm</option>
                            @if (!empty(getAllGroups()))
                                @foreach (getAllGroups() as $item)
                                    <option value="{{ $item->id }}"
                                        {{ request()->group_id == $item->id ? 'selected' : false }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control form-search" placeholder="Tìm kiếm nâng cao"
                            name='keywords' value="{{ request()->keywords }}">
                    </div>
                    <div class="col-3">
                        <input type="submit" name="btn-search" value="search" class="btn btn-primary">
                    </div>
                </div>

            </form>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                @if (session('errors'))
                    <div class="alert alert-danger">
                        {{ session('errors') }}
                    </div>
                @endif
                <div class="alert alert-success">
                    Lượt truy cập: {{ $visit }}
                </div>
                <div class="analytic">
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'all']) }}" class="text-primary">Kích
                        hoạt<span class="text-muted">({{ $count[0] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Vô hiệu
                        hóa<span class="text-muted">({{ $count[1] }})</span></a>
                </div>
                <form action="{{ route('projectv1.user.action') }}" method="post">
                    @csrf
                    <div class="form-action form-inline py-3">
                        <select class="form-control mr-1" name='act'>
                            <option value="">Chọn</option>
                            @foreach ($list_act as $k => $v)
                                <option value="{{ $k }}">{{ $v }}</option>
                            @endforeach
                        </select>
                        <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                    </div>
                    <table class="table table-striped table-checkall">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" name="checkall">
                                </th>
                                <th scope="col">#</th>
                                <th scope="col">Avatar</th>
                                <th scope="col">
                                    Họ tên
                                    <a href="?sort-by=name&sort-type={{ $sortType }}"> <i
                                            class="fa-solid fa-arrow-down-up-across-line"></i></a>

                                </th>
                                <th scope="col">
                                    Email
                                    <a href="?sort-by=email&sort-type={{ $sortType }}">
                                        <i class="fa-solid fa-arrow-down-up-across-line"></i>
                                    </a>
                                </th>
                                <th scope="col">Nhóm</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Quyền</th>
                                <th scope="col">
                                    Ngày tạo
                                    <a href="?sort-by=created_at&sort-type={{ $sortType }}"> <i
                                            class="fa-solid fa-arrow-down-up-across-line"></i> </a>
                                </th>
                                @if (request()->status != 'trash')
                                    <th scope="col">Tác vụ</th>
                                @endif
                                <th>Status</th>
                                <th>Last Seen</th>


                            </tr>
                        </thead>
                        <tbody id="results">
                            @if ($users->total() > 0)
                                @php
                                    $t = 0;
                                @endphp
                                @foreach ($users as $user)
                                    @php
                                        $t++;
                                    @endphp
                                    <tr>
                                        <td>
                                            <input type="checkbox" name='list_check[]' value="{{ $user->id }}">
                                        </td>
                                        <td scope="row">
                                            {{ $t }}
                                        </td>
                                        <td>
                                            <img src="{{ Avatar::create($user->name)->toBase64() }}" class=""
                                                alt="">
                                        </td>
                                        <td>
                                            <a href="?sort-by=name&sort-type={{ $sortType }}"></a>
                                            {{ $user->name }}
                                        </td>
                                        <td>
                                            {{ $user->email }}
                                        </td>
                                        <td>
                                            {{ $user->group_name }}
                                        </td>
                                        <td>
                                            {!! $user->status == 0 ? '<button class="btn btn-danger btn-sm">Chưa kích hoạt</button>' : '<button class="btn btn-success btn-sm">Kích hoạt</button>' !!}
                                        </td>
                                        <td>
                                            {{ optional($user->role)->name }}
                                        </td>
                                        <td>
                                            {{ date('d/m/Y', strtotime($user->created_at)) }}
                                        </td>
                                        <td>
                                            @if (request()->status != 'trash')
                                                <a href="{{ route('projectv1.user.edit', $user->id) }}"
                                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-edit"></i></a>
                                            @endif
                                            @if (Auth::id() != $user->id)
                                                @if (request()->status != 'trash')
                                                    <a href="{{ route('projectv1.user.delete', $user->id) }}"
                                                        onclick="return confirm('Bạn chắc chắn xóa bản ghi này')"
                                                        class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                        data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                            class="fa fa-trash"></i></a>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if(Cache::has('user-is-online-' . $user->id))
                                                <span class="text-success">Online</span>
                                            @else
                                                <span class="text-secondary">Offline</span>
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($user->last_seen)->diffForHumans() }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7">
                                        <p class="text-center">
                                            Không tìm thấy bản ghi này !
                                        </p>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    {{ $users->appends(request()->input())->links() }}
                </form>

            </div>
        </div>
    </div>
@endsection
<script>
    var SITEURL = "{{ url('/') }}";
    var page = 1; //track user scroll as page number, right now page number is 1
    load_more(page); //initial content load
    $(window).scroll(function() { //detect page scroll
       if($(window).scrollTop() + $(window).height() >= $(document).height()) { //if user scrolled from top to bottom of the page
       page++; //page number increment
       load_more(page); //load content
       }
     });
     function load_more(page){
         $.ajax({
            url: SITEURL + "projectv1/admin/user/list?page=" + page,
            type: "get",
            datatype: "html",
            beforeSend: function()
            {
               $('.ajax-loading').show();
             }
         })
         .done(function(data)
         {
             if(data.length == 0){
             console.log(data.length);
             //notify user if nothing to load
             $('.ajax-loading').html("No more records!");
             return;
           }
           $('.ajax-loading').hide(); //hide loading animation once data is received
           $("#results").append(data); //append data into #results element
            console.log('data.length');
        })
        .fail(function(jqXHR, ajaxOptions, thrownError)
        {
           alert('No response from server');
        });
     }
 </script>
