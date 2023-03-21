<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['vendor_id', 'sku', 'part', 'part_number', 'type', 'manufacturer', 'name', 'image', 'category_id', 'subcategory_id', 'brand_id', 'make_id', 'model_id', 'year_id', 'engine_id', 'warranty', 'discount', 'price'];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function make()
    {
        return $this->belongsTo(Make::class, 'make_id', 'id');
    }

    public function model()
    {
        return $this->belongsTo(Model::class, 'model_id', 'id');
    }

    public function year()
    {
        return $this->belongsTo(Year::class, 'year_id', 'id');
    }

    public function engine()
    {
        return $this->belongsTo(Engine::class, 'engine_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    public function specifications()
    {
        return $this->hasMany(ProductSpecification::class, 'product_id', 'id');
    }

//    public function matches()
//    {
//        return $this->hasMany(ProductMatch::class, 'id', 'id');
//    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class, 'id', 'id');
    }
}
