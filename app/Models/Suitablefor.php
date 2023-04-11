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
        return $this->belongsTo(Make::class, 'make_id', 'id');
    }

    public function model()
    {
        return $this->belongsTo(Models::class, 'model_id', 'id');
    }

    public function year()
    {
        return $this->belongsTo(Year::class, 'year_id', 'id');
    }

    public function engine()
    {
        return $this->belongsTo(Engine::class, 'engine_id', 'id');
    }
}
