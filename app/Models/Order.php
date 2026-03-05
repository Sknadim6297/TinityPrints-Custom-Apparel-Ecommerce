<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'customer_name',
        'phone',
        'email',
        'product_id',
        'product_name',
        'product_size',
        'quantity',
        'subtotal',
        'discount_amount',
        'total_amount',
        'payment_method',
        'coupon_code',
        'design_request_id',
        'custom_design_status',
        'payment_status',
        'order_status',
        'shipping_address',
        'shipping_city',
        'shipping_state',
        'shipping_postal_code',
        'shipping_country',
        'shipping_partner',
        'shipping_weight_grams',
        'shipping_cost',
        'shipping_method',
        'tracking_number',
        'delivery_status',
    ];

    protected $casts = [
        'shipping_cost' => 'decimal:2',
        'shipping_weight_grams' => 'integer',
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function designRequest()
    {
        return $this->belongsTo(DesignRequest::class);
    }

    public function refundRequest()
    {
        return $this->hasOne(RefundRequest::class);
    }
}
