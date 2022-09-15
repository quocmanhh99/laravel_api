<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $guarded = [];

    public static function recursive($categories,$parent = 0,$level = 0){
        $result = [];
        if(count($categories) > 0){
            foreach($categories as $item){
                if( $item->parent_id == $parent){
                    $item->level = $level;
                    $result[] = $item;
                    unset($categories->id);
                    $child = self::recursive($categories,$item->id,$level +1);
                    $result = array_merge($result, $child );
                }
            }
        }
        return $result;
    }
}
