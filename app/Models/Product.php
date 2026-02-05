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
        'drop_name',
        'drop_story',
        'drop_start_at',
        'drop_end_at',
        'stock_limit',
        'quantity_limit',
        'countdown_enabled',
        'auto_hide_out_of_stock',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'is_limited_edition' => 'boolean',
        'is_active' => 'boolean',
        'base_price' => 'decimal:2',
        'drop_start_at' => 'datetime',
        'drop_end_at' => 'datetime',
        'countdown_enabled' => 'boolean',
        'auto_hide_out_of_stock' => 'boolean',
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

    public function totalStock(): int
    {
        return (int) $this->sizes()->sum('stock_quantity');
    }
}
