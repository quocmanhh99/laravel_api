<?php

namespace App\Http\Controllers\Demo\Blog;

use App\Http\Controllers\Controller;
use App\Models\Demo\Blog\DemoBlog;
use App\Models\Demo\Comment\DemoComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DemoBlogController extends Controller
{
    public function index(){
        $blogs = DemoBlog::all();
        return view('demo.blog.index',compact('blogs'));
    }

    public function detail($id){
        $blog = DemoBlog::findOrFail($id);
        return view('demo.blog.detail',compact('blog'));
    }

    public function comment($blog_id,Request $request){
        $user_id = Auth::user()->id;
        $validator = Validator::make($request->all(),
        [
            'content' => 'required',
        ],
        [
            'content.required' => 'Nội dung bình luận không được để trống',
        ]
    );
    if($validator->fails()){
        return response()->json(['error' =>  $validator->errors()->first()] );
    }else{
        $data = [
            'user_id' => $user_id,
            'blog_id' => $blog_id,
            'content' => $request->content
        ];
        if($comment = DemoComment::create($data) ){
            $comments = DemoComment::where(['blog_id'=> $blog_id,'reply_id'=>0])->orderBy('id','desc')->get();
            return view('demo.blog.list-comment',compact('comments'));
            // return response()->json(['data'=>$comment]);
        }
    }

    }
}
