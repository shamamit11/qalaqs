<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['supplier_id', 'sku', 'part', 'part_number', 'product_type', 'manufacturer', 'name', 'image', 'product_category_id', 'product_sub_category_id', 'product_brand_id', 'product_make_id', 'product_model_id', 'product_year_id', 'product_engine_id', 'warranty', 'price'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'id');
    }

    public function subcategory()
    {
        return $this->belongsTo(ProductSubCategory::class, 'product_sub_category_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo(ProductBrand::class, 'product_brand_id', 'id');
    }

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

    public function engine()
    {
        return $this->belongsTo(ProductEngine::class, 'product_engine_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id')->orderBy('order', 'asc');
    }

    public function image()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id')->where('is_primary', 1);
    }

    public function specifications()
    {
        return $this->hasMany(ProductSpecification::class, 'product_id', 'id');
    }

    public function matches()
    {
        return $this->hasMany(ProductMatch::class, 'product_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class, 'product_id', 'id');
    }
}
