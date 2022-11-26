<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductEngine extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['prouct_make_id', 'prouct_model_id', 'product_year_id', 'name', 'status'];

    public function make()
    {
        return $this->belongsTo(ProductMake::class, 'prouct_make_id', 'id');
    }

    public function model()
    {
        return $this->belongsTo(ProductModel::class, 'prouct_model_id', 'id');
    }

    public function year()
    {
        return $this->belongsTo(ProductYear::class, 'prouct_year_id', 'id');
    }
}
