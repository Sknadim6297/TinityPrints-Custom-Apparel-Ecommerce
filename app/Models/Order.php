<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'customer_name',
        'phone',
        'email',
        'product_id',
        'product_name',
        'product_size',
        'quantity',
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
    ];

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
