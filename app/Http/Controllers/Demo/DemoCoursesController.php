<?php

namespace App\Http\Controllers\Demo;

use App\Http\Controllers\Controller;
use App\Models\Demo\DemoCourses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Response;

class DemoCoursesController extends Controller
{
    private $title = 'Khóa học';
    private $model;
    public function __construct()
    {

        $this->model = new DemoCourses();
        $routeName = Route::currentRouteName();
        $arr = explode('.',$routeName);
        $arr = array_map('ucfirst',$arr);
        $title = implode('-',$arr);

        $this->middleware(function ($request, $next) {
            session(['module_active' => 'Courses']);
            return $next($request);
        });
        View::share('title',$title);
    }
    public function index()
    {
        return view('demo.courses.index');
    }


    public function getCourses(Request $request,  DemoCourses $article)
    {
        $data = $article->getData();
        return DataTables::of($data)
            ->addColumn('Actions', function($data) {
                return '<button type="button" class="btn btn-success btn-sm" id="getEditArticleData" data-id="'.$data->id.'">Sửa</button>
                    <button type="button" data-id="'.$data->id.'" data-toggle="modal" data-target="#DeleteArticleModal" class="btn btn-danger btn-sm" id="getDeleteId">Xóa</button>';
            })
            ->rawColumns(['Actions'])
            ->make(true);
    }

    public function store(Request $request, DemoCourses $article)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:5|unique:courses',
            'description' => 'required|min:6|max:255',
        ]);

        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 400);
        }

        $article->storeData($request->all());

        return Response::json(array('success' => true), 200);
    }

    public function edit($id)
    {

        $article = new DemoCourses;
        $data = $article->findData($id);

        $html = '<div class="form-group">
                    <label for="Title">Tiêu đề:</label>
                    <input type="text" class="form-control" name="title" id="editTitle" value="'.$data->title.'">
                    <span id="title_error" class="err"></span> <br>
                </div>
                <div class="form-group">
                    <label for="Name">Mô tả:</label>
                    <textarea class="form-control" name="description" id="editDescription">'.$data->description.'
                    </textarea>
                </div>';

        return response()->json(['html'=>$html]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 400);
        }

        $article = new DemoCourses;
        $article->updateData($id, $request->all());

        return Response::json(array('success' => true), 200);
    }

    public function destroy($id)
    {
        $article = new DemoCourses;
        $article->deleteData($id);

        return response()->json(['success'=>'Bài viết đã được xóa thành công']);
    }
}
