<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Courier extends Authenticatable
{
    use HasFactory;
    protected $guard = 'courier';

    protected $fillable = ['courier_code', 'business_name', 'first_name', 'last_name', 'designation', 'mobile', 'phone', 'image', 'license_image', 'address', 'city', 'email', 'password', 'account_type', 'verification_code', 'email_verified', 'status', 'is_deleted'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}