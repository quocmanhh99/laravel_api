@extends('demo.datatable.layout')

@section('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <style>
        .err {
            color: red;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h3 class="text-center">Laravel Ajax CRUD </h3>
                            <button style="float: right; font-weight: 900;" class="btn btn-info btn-sm m-2" type="button"
                                data-toggle="modal" data-target="#CreateArticleModal">
                                Thêm bài viết
                            </button>
                            <a href="{{ route('projectv1.user.list') }}" class="btn btn-primary btn-sm">Thành viên</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered datatable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tiêu đề</th>
                                        <th>Mô tả</th>
                                        <th>Username</th>
                                        <th width="150" class="text-center">Hành động</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Article Modal -->
    <div class="modal" id="CreateArticleModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Thêm bài viết</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none; ">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                        <strong> Bài viết đã được thêm thành công ! </strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="form-group" id='title_group'>
                        <label for="title">Tiêu đề:</label>
                        <input type="text" class="form-control" name="title" id="title">
                        {{-- <span id="titleError" class="alert-message"></span>
                                <span id="title_error" class="alert-message"></span> --}}
                        <span id="title_error" class='err'></span> <br>
                    </div>
                    <div class="form-group" id='description_group'>
                        <label for="description">Mô tả:</label>
                        <textarea class="form-control" name="description" id="description">

                        </textarea>
                        <span id="description_error" class="err"></span> <br>
                    </div>

                </div>
                <!-- Modal footer -->
                <div class="modal-footer">

                    <button type="button" class="btn btn-success" id="SubmitCreateArticleForm">Tạo</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Thoát</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Article Modal -->
    <div class="modal" id="EditArticleModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Sửa bài viết</h4>
                    <button type="button" class="close modelClose" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="alert alert-danger alert-danger1 alert-dismissible fade show" role="alert"
                        style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                        <strong> Bài viết đã được sửa thành công ! </strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="EditArticleModalBody">

                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="SubmitEditArticleForm">Cập nhật</button>
                    <button type="button" class="btn btn-danger modelClose" data-dismiss="modal">Thoát</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Article Modal -->
    <div class="modal" id="DeleteArticleModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Xóa bài viết</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                        <strong> Bài viết đã được xóa thành công ! </strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <h5>
                        Bạn có chắc chắn muốn xóa bài viết này không ?</h5>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="SubmitDeleteArticleForm">Có</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Không</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // init datatable.
            var dataTable = $('.datatable').DataTable({
                processing: false,
                serverSide: true,
                autoWidth: false,
                pageLength: 5,
                scrollX: true,
                "order": [
                    [0, "desc"]
                ],
                ajax: '{{ route('get-courses') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'Actions',
                        name: 'Actions',
                        orderable: true,
                        serachable: true,
                        sClass: 'text-center'
                    },
                ]
            });

            // Create article Ajax request.
            $('#SubmitCreateArticleForm').click(function(e) {
                $(".form-group").removeClass("has-error");
                $(".help-block").remove();
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('courses.store') }}",
                    method: 'post',
                    data: {
                        title: $('#title').val(),
                        description: $('#description').val(),
                    },
                    success: function(result) {
                        $('.alert-danger').hide();
                        $('.alert-success').show();
                        $('.datatable').DataTable().ajax.reload();
                        setInterval(function() {
                            $('.alert-success').hide();
                            $('#CreateArticleModal').modal('hide');
                            location.reload();
                        }, 1000);
                    },
                    error: function(response) {
                        $('.alert-danger').html('');
                        $.each(response.responseJSON.errors, function(field_name, error) {
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
                    }
                });
            });

            // Get single article in EditModel
            $('.modelClose').on('click', function() {
                $('#EditArticleModal').hide();
            });
            var id;
            $('body').on('click', '#getEditArticleData', function(e) {
                // e.preventDefault();
                $('.alert-danger').html('');
                $('.alert-danger').hide();
                id = $(this).data('id');
                $.ajax({
                    url: "{{ url('/') }}/demo/courses/" + id + "/edit",
                    method: 'GET',
                    // data: {
                    //     id: id,
                    // },
                    success: function(result) {
                        $('#EditArticleModalBody').html(result.html);
                        $('#EditArticleModal').show();
                    }
                });
            });

            // Update article Ajax request.
            $('#SubmitEditArticleForm').click(function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('/') }}/demo/courses/" + id,
                    method: 'PUT',
                    data: {
                        title: $('#editTitle').val(),
                        description: $('#editDescription').val(),
                    },
                    success: function(result) {
                        $('.alert-danger1').hide();
                        $('.alert-success').show();
                        $('.datatable').DataTable().ajax.reload();
                        setInterval(function() {
                            $('.alert-success').hide();
                            $('#EditArticleModal').hide();
                            location.reload();
                        }, 1000);
                    },
                    error: function(response) {
                        $('.alert-danger1').html('');
                        $.each(response.responseJSON.errors, function(field_name, error) {
                            $("#" + field_name + "_error").text(error);
                            $('.alert-danger1').show();
                            $('.alert-danger1').append('<strong><span>' + error +
                                '</span></strong> <br>');
                        })
                    }
                });
            });

            // Delete article Ajax request.
            var deleteID;
            $('body').on('click', '#getDeleteId', function() {
                deleteID = $(this).data('id');
            })
            $('#SubmitDeleteArticleForm').click(function(e) {
                e.preventDefault();
                var id = deleteID;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('/') }}/demo/courses/" + id,
                    method: 'DELETE',
                    success: function(result) {
                        $('.alert-success').show();
                        // $('.datatable').DataTable().ajax.reload();
                        setInterval(function() {
                            $('.alert-success').hide();
                            $('#DeleteArticleModal').hide();
                            location.reload();
                        }, 1000);
                    }
                });
            });
        });
    </script>
@endsection
