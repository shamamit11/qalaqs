<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'image', 'part_number', 'chasis_number', 'make_id', 'model_id', 'year_id', 'qty', 'name', 'email', 'mobile', 'address', 'city', 'country'
    ];

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
