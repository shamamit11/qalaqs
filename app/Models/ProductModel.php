<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['product_make_id', 'name', 'status'];

    public function make()
    {
        return $this->belongsTo(ProductMake::class, 'product_make_id', 'id');
    }
}
