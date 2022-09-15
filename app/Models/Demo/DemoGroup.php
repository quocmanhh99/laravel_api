<?php

namespace App\Models\Demo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DemoGroup extends Model
{
    use HasFactory;
    protected $table = 'groups';
    protected $guarded = [];

    public function getAll(){
        $groups = DB::table($this->table)
        ->orderBy('name','ASC')
        ->get();

        return $groups;
    }
}
