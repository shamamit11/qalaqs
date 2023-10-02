<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Garage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'address', 'phone', 'logo', 'image', 'map', 'description', 'status'
    ];

}