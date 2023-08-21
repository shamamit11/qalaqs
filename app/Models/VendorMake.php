<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorMake extends Model
{
    use HasFactory;
    protected $fillable = [
        'vendor_id', 'make_id', 'year_from_id', 'year_to_id', 'part_type', 'market'
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
    }

    public function make()
    {
        return $this->belongsTo(Make::class, 'make_id', 'id');
    }

    public function yearFrom()
    {
        return $this->belongsTo(Year::class, 'year_from_id', 'id');
    }

    public function yearTo()
    {
        return $this->belongsTo(Year::class, 'year_from_to', 'id');
    }
}
