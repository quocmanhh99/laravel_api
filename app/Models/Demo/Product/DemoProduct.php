<?php

namespace App\Models\Demo\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemoProduct extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $guarded = [];
    // protected $fillable = ['product_name','product_status'];

    protected $hidden = ['deleted_at'];
}
