@extends('layouts.admin')
@section('content')
    <style>
        div.bootstrap-tagsinput {
            width: 100%;
        }

        .bootstrap-tagsinput .tag {
            margin-right: 2px;
            color: black !important;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Danh mục sản phẩm
                    </div>
                    <div class="card-body">
                        <form action='{{ route('projectv1.user.store') }}' method='POST'>
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên danh mục</label>
                                <input class="form-control" type="text" name="name" id="name"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <small class='text-danger'>{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="role_id">Danh mục cha</label>
                                <select class="form-control" id="role_id" name='role_id'>
                                    <option value="">Chọn danh mục</option>
                                    @foreach ($category_product as $item)
                                    <option value="{{ $item->id }}">
                                        <a href="">
                                            @php
                                                echo str_repeat('|--',$item->level).' '.$item->name
                                            @endphp
                                        </a>
                                    </option>
                                    @endforeach
                                    {{-- <option value="2" @if (old('role_id') == 2) selected @endif>User</option> --}}
                                </select>
                                @error('role_id')
                                    <small class='text-danger'>{{ $message }}</small>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary" name='btn-add' value="Thêm mới">Thêm mới</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <h5 class="text-center mt-2 mb-2">Danh sách danh mục sản phẩm</h5>
                <table class="table table-bordered bg-light">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">First</th>
                            <th scope="col">Last</th>
                            <th scope="col">Handle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td colspan="2">Larry the Bird</td>
                            <td>@twitter</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
