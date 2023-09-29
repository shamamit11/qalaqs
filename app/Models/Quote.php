<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'quote_id', 'user_id', 'part_type', 'make_id', 'model_id', 'year_id', 'engine', 'vin'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

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
}
