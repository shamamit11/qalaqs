<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    use HasFactory;

    protected $fillable = [ 'name', 'description', 'date', 'time', 'location', 'phone', 'logo', 'image', 'map', 'status' ];
}
