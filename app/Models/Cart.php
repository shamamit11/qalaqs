<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'session_id', 'user_id', 'item_count', 'promo_code', 'promo_type','promo_value', 'sub_total'
    ];

    public function items()
    {
        return $this->hasMany(CartItem::class, 'cart_session_id', 'session_id');
    }
}
