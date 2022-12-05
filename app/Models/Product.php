<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['supplier_id', 'sku', 'part', 'part_number', 'product_type', 'manufacturer', 'name', 'image', 'product_category_id', 'product_sub_category_id', 'product_brand_id', 'product_make_id', 'product_model_id', 'product_year_id', 'product_engine_id', 'warranty', 'price'];

    public function make()
    {
        return $this->belongsTo(ProductMake::class, 'product_make_id', 'id');
    }

    public function model()
    {
        return $this->belongsTo(ProductModel::class, 'product_model_id', 'id');
    }

    public function year()
    {
        return $this->belongsTo(ProductYear::class, 'product_year_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    public function specifications()
    {
        return $this->hasMany(ProductSpecification::class, 'product_id', 'id');
    }

    public function matches()
    {
        return $this->hasMany(ProductMatch::class, 'product_id', 'id');
    }
}
