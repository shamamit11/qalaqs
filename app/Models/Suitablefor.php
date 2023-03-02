<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suitablefor extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'make_id', 'model_id', 'year_id', 'engine_id'];

    public function make()
    {
        return $this->belongsTo(ProductMake::class, 'make_id', 'id');
    }

    public function model()
    {
        return $this->belongsTo(ProductModel::class, 'model_id', 'id');
    }

    public function year()
    {
        return $this->belongsTo(ProductYear::class, 'year_id', 'id');
    }

    public function engine()
    {
        return $this->belongsTo(ProductEngine::class, 'engine_id', 'id');
    }
}
