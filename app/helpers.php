<?php

use App\Support\ImageOptimizer;

if (! function_exists('product_image_url')) {
    function product_image_url(?string $path, string $variant = ImageOptimizer::VARIANT_CARD): string
    {
        return ImageOptimizer::url($path, $variant);
    }
}
