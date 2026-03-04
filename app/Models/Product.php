<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'vendor_id',
        'name',
        'description',
        'price',
        'unit',
        'quantity',
        'threshold_qty',
        'is_active',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
