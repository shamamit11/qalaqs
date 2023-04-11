<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemStatusUpdate extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id', 'order_item_id', 'user_id', 'vendor_id', 'status_id', 'updated_by'
    ];

    public function order_status()
    {
        return $this->belongsTo(OrderStatus::class, 'status_id', 'id');
    }
}
