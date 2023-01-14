<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductYear extends Model
{
    use HasFactory;
    protected $fillable = ['product_make_id', 'product_model_id', 'name', 'status'];

    public function make()
    {
        return $this->belongsTo(ProductMake::class, 'product_make_id', 'id');
    }

    public function model()
    {
        return $this->belongsTo(ProductModel::class, 'product_model_id', 'id');
    }

}
