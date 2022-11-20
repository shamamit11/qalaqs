<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;
    protected $guard = 'admin';

    protected $fillable = ['name', 'email', 'image', 'user_type', 'username', 'password', 'status'];

    protected $hidden = ['password', 'remember_token'];
}
