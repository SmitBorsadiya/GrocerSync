<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'address',
        'is_active',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
