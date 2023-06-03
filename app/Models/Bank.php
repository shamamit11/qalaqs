<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $fillable = ['vendor_id', 'bank_name', 'account_name', 'account_no', 'iban', 'image' ];
}
