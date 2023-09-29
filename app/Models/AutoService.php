<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutoService extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'phone', 'logo', 'image', 'status'
    ];
}
