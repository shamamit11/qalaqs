<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'cart_session_id', 'product_id', 'item_count', 'sub_total', 'vendor_id'
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_session_id', 'session_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
