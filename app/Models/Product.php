<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['supplier_id', 'sku', 'part', 'part_number', 'product_type', 'manufacturer', 'name', 'image', 'product_category_id', 'product_sub_category_id', 'product_brand_id', 'prouct_make_id', 'prouct_model_id', 'prouct_year_id', 'product_engine_id', 'warranty', 'price'];
}
