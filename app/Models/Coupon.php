<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'usage_limit',
        'usage_count',
        'expires_at',
        'min_order_value',
        'customer_email',
        'is_active',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'discount_value' => 'decimal:2',
        'min_order_value' => 'decimal:2',
    ];
}
