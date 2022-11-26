<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductMatch extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['product_id', 'prouct_make_id', 'prouct_model_id', 'prouct_year_id', 'product_engine_id'];
}
