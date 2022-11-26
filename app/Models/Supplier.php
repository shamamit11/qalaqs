<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Authenticatable
{
    use HasFactory, SoftDeletes;
    protected $guard = 'supplier';

    protected $fillable = ['supplier_code', 'name', 'address', 'city', 'state', 'zipcode', 'country_id', 'coordinates', 'phone', 'mobile', 'image', 'email', 'password', 'remember_token', 'verification_code', 'email_verified', 'status', ];

    protected $hidden = ['password', 'remember_token'];
}
