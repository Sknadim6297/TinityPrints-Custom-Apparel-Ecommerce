<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'category',
        'category_id',
        'brand',
        'rating',
        'fit_type',
        'sleeve_type',
        'sleeve_type_id',
        'collection_type_id',
        'product_weight_grams',
        'mrp',
        'selling_price',
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
        'product_weight_grams' => 'integer',
        'mrp' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'base_price' => 'decimal:2',
        'rating' => 'decimal:1',
        'drop_start_at' => 'datetime',
        'drop_end_at' => 'datetime',
        'countdown_enabled' => 'boolean',
        'auto_hide_out_of_stock' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        // Automatically sync category string when category_id is set
        static::saving(function ($product) {
            if ($product->category_id) {
                $category = Category::find($product->category_id);
                if ($category) {
                    $product->category = $category->slug;
                }
            }
        });
    }

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

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function sleeveType()
    {
        return $this->belongsTo(SleeveType::class, 'sleeve_type_id');
    }

    public function collectionType()
    {
        return $this->belongsTo(CollectionType::class, 'collection_type_id');
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(ProductReview::class)->where('is_approved', true);
    }

    public function averageRating()
    {
        return $this->approvedReviews()->avg('rating') ?? 0;
    }

    public function totalStock(): int
    {
        return (int) $this->sizes()->sum('stock_quantity');
    }

    // Getter for price (using base_price)
    public function getPriceAttribute()
    {
        return $this->selling_price ?? $this->base_price;
    }

    public function getDiscountPercentageAttribute(): int
    {
        $mrp = (float) ($this->mrp ?? 0);
        $sellingPrice = (float) ($this->selling_price ?? $this->base_price ?? 0);

        if ($mrp <= 0 || $sellingPrice >= $mrp) {
            return 0;
        }

        return (int) round((($mrp - $sellingPrice) / $mrp) * 100);
    }

    // Getter for stock_quantity (total stock)
    public function getStockQuantityAttribute()
    {
        return $this->totalStock();
    }

    // Method to get sale price if applicable
    public function getSalePriceAttribute()
    {
        $sellingPrice = $this->selling_price ?? $this->base_price;
        if ($this->discount_percentage > 0) {
            return $sellingPrice;
        }

        return null;
    }
}
