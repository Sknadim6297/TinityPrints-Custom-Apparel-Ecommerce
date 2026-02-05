<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'category',
        'fit_type',
        'sleeve_type',
        'base_price',
        'is_limited_edition',
        'drop_month',
        'stock_limit',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'is_limited_edition' => 'boolean',
        'is_active' => 'boolean',
        'base_price' => 'decimal:2',
    ];

    public function colors()
    {
        return $this->hasMany(ProductColor::class);
    }

    public function sizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    public function images()
    {
        return $this->hasManyThrough(ProductImage::class, ProductColor::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
