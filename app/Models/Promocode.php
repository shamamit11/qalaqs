<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
{
    use HasFactory;
    protected $fillable = [
        'code', 'discount_type', 'value', 'max_num_usage', 'max_num_per_user','status'
    ];
}
