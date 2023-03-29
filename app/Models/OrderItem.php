<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id', 'product_id', 'item_count', 'amount', 'sub_total', 'tax_total', 'delivery_distance','delivery_charge',
        'cod_charge', 'grand_total', 'vendor_id', 'order_status_id'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
