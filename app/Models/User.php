<?php

namespace App\Models;

use App\Models\Demo\Role\DemoRole;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role(){
        return $this->belongsTo(DemoRole::class);
    }

    public function getAllUsers($keyword='',$keywords=null,$filters = [],$sortByArr = null){
        $users = User::select('users.*','groups.name as group_name')
        ->join('groups','users.group_id','=','groups.id');

        if(!empty($sortByArr) && is_array($sortByArr)){
            if( !empty($sortByArr['sortBy']) && !empty($sortByArr['sortType']) ){
                $sortBy = trim($sortByArr['sortBy']);
                $sortType = trim($sortByArr['sortType']);
                $users = $users->orderBy('users.'.$sortBy,$sortType );
            }else{
                $users = $users->orderBy('users.created_at','desc');
            }
        }

        if(!empty($filters)){
            $users = $users->where($filters);
        }

        if(!empty($keyword)){
            $users = $users->where('users.name', 'LIKE', "%{$keyword}%");
        }

        if(!empty($keywords)){
            $users = $users->where(function($query) use ($keywords){
                $query->orWhere('users.name', 'LIKE', "%{$keywords}%");
                $query->orWhere('users.email', 'LIKE', "%{$keywords}%");
            });
        }

        $users = $users->paginate(5);

        return $users;
    }

    public function getOnlyTrashed($sortByArr = null){
        $users = User::onlyTrashed()
        ->select('users.*','groups.name as group_name')
        ->join('groups','users.group_id','=','groups.id');

        if(!empty($sortByArr) && is_array($sortByArr)){
            if( !empty($sortByArr['sortBy']) && !empty($sortByArr['sortType']) ){
                $sortBy = trim($sortByArr['sortBy']);
                $sortType = trim($sortByArr['sortType']);
                $users = $users->orderBy('users.'.$sortBy,$sortType );
            }else{
                $users = $users->orderBy('users.created_at','desc');
            }
        }

        // if(!empty($filters)){
        //     $users = $users->where($filters);
        // }

        // if(!empty($keyword)){
        //     $users = $users->where('users.name', 'LIKE', "%{$keyword}%");
        // }

        // if(!empty($keywords)){
        //     $users = $users->where(function($query) use ($keywords){
        //         $query->orWhere('users.name', 'LIKE', "%{$keywords}%");
        //         $query->orWhere('users.email', 'LIKE', "%{$keywords}%");
        //     });
        // }

        $users = $users->paginate(10);

        return $users;
    }
}
