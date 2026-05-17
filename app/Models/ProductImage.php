<?php

namespace App\Models;

use App\Support\ImageOptimizer;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected static function booted(): void
    {
        static::saved(function (ProductImage $image) {
            if ($image->image_path) {
                ImageOptimizer::warmVariants($image->image_path);
            }
        });
    }

    protected $fillable = [
        'product_color_id',
        'image_type',
        'image_path',
    ];

    public function color()
    {
        return $this->belongsTo(ProductColor::class, 'product_color_id');
    }

    public function url(string $variant = ImageOptimizer::VARIANT_CARD): string
    {
        return ImageOptimizer::url($this->image_path, $variant);
    }
}
