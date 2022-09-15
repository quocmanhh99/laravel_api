<?php

namespace App\Models\Demo\Blog;

use App\Models\Demo\Comment\DemoComment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemoBlog extends Model
{
    use HasFactory;
    protected $table = 'blog';
    protected $guarded = [];

    public function comments(){
        return $this->hasMany(DemoComment::class,'blog_id','id')->orderBy('id','desc');
    }
}
