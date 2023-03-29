<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $table = 'address';
    public $timestamps = false;

    protected $fillable = ['name', 'building_name', 'street_name', 'city','country','mobile_no'];
}
