<?php

namespace App\Console\Commands;

use App\Models\ProductImage;
use App\Support\ImageOptimizer;
use Illuminate\Console\Command;

class WarmProductImageCache extends Command
{
    protected $signature = 'images:warm-product-cache';

    protected $description = 'Generate optimized thumbnail/card/large caches for all product images';

    public function handle(): int
    {
        $count = 0;

        ProductImage::query()
            ->whereNotNull('image_path')
            ->orderBy('id')
            ->chunkById(50, function ($images) use (&$count) {
                foreach ($images as $image) {
                    ImageOptimizer::warmVariants($image->image_path);
                    $count++;
                }
            });

        $this->info("Warmed optimized variants for {$count} product images.");

        return self::SUCCESS;
    }
}
