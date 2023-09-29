<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempQuoteItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'quote_session_id', 'user_id', 'part_image', 'part_name', 'part_number', 'qty'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
