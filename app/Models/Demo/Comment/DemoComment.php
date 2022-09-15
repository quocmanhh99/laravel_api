<?php

namespace App\Models\Demo\Comment;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemoComment extends Model
{
    use HasFactory;
    protected $table = 'comment';
    protected $guarded = [];

    public function cus(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function replies(){
        return $this->hasMany(DemoComment::class,'reply_id','id');
    }
}
