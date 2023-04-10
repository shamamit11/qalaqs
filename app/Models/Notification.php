<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'device_id', 'receiver_id', 'receiver_type', 'title', 'message', 'status'];

}
