@extends('layouts.admin')
@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tiêu đề</th>
                                <th scope="col">Slug</th>
                                <th scope="col">Hình ảnh</th>
                                <th scope="col">Quản lý</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $t = 0;
                            @endphp
                            @foreach ($blogs as $blog )
                            @php
                            $t++;
                            @endphp
                            <tr>
                                <th scope="row">{{ $t }}</th>
                                <td>{{ $blog->name }}</td>
                                <td>{{ Str::slug($blog->name, '-') }}</td>
                                <td>
                                    <img src="{{ $blog->image }}" alt="" class="img-fuild w-25 h-25">
                                </td>
                                <td>
                                    <a href="{{ route('demo.admin.blog.detail',$blog->id) }}" class="btn btn-sm btn-success">Chi tiết</a>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
