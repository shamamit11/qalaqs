<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMatch extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'product_make_id', 'product_model_id', 'product_year_id', 'product_engine_id'];

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
}
