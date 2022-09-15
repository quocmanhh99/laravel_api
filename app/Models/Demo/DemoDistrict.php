<?php

namespace App\Models\Demo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemoDistrict extends Model
{
    use HasFactory;
    protected $table = 'districts';
    protected $guarded = [];
}
