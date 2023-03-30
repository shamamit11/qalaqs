<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id', 'user_id', 'item_count', 'vat_percentage', 'vat_amount', 'promo_code', 'promo_type','promo_value',
        'sub_total', 'tax_total', 'delivery_charge', 'delivery_name', 'delivery_address', 'delivery_city', 'delivery_country', 'delivery_zip',
        'delivery_phone', 'billing_name', 'billing_address', 'billing_city', 'billing_country', 'billing_zip', 'billing_phone',
        'order_note', 'cancel_reason_id','cancel_note', 'payment_method', 'payment_transaction_id'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }
}
