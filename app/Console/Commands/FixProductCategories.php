<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class FixProductCategories extends Command
{
    protected $signature = 'products:fix-categories';

    protected $description = 'Populate category_id for products based on their string category field';

    public function handle()
    {
        $this->info('Starting to fix product categories...');

        // Get all unique string categories
        $categories = Product::whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->pluck('category')
            ->toArray();

        $this->info('Found ' . count($categories) . ' unique categories: ' . implode(', ', $categories));

        $fixed = 0;
        $notFound = 0;

        foreach ($categories as $categoryString) {
            // Try to find matching category by name or slug
            $normalizedName = Str::of($categoryString)->replace(['-', '_'], ' ')->lower()->value();
            
            $categoryRecord = Category::query()
                ->where(function ($query) use ($categoryString, $normalizedName) {
                    $query->where('slug', $categoryString)
                          ->orWhere('slug', Str::slug($categoryString))
                          ->orWhereRaw('LOWER(name) = ?', [$normalizedName])
                          ->orWhereRaw('LOWER(name) = ?', [ucfirst(str_replace('-', ' ', $categoryString))]);
                })
                ->first();

            if ($categoryRecord) {
                $count = Product::where('category', $categoryString)
                    ->whereNull('category_id')
                    ->update(['category_id' => $categoryRecord->id]);

                $this->line("✓ Mapped '{$categoryString}' → Category ID {$categoryRecord->id} ({$count} products updated)");
                $fixed += $count;
            } else {
                $this->warn("✗ Could not find category for '{$categoryString}'");
                $notFound++;
            }
        }

        // Also check for products that have category_id but no category string
        $productsWithIdButNoString = Product::whereNotNull('category_id')
            ->where(function ($query) {
                $query->whereNull('category')
                      ->orWhere('category', '');
            })
            ->get();

        if ($productsWithIdButNoString->count() > 0) {
            $this->info('Found ' . $productsWithIdButNoString->count() . ' products with category_id but no category string');
            foreach ($productsWithIdButNoString as $product) {
                $categoryName = $product->category()->first()?->slug;
                if ($categoryName) {
                    $product->update(['category' => $categoryName]);
                }
            }
        }

        $this->info("✓ Fixed {$fixed} products");
        if ($notFound > 0) {
            $this->warn("⚠ {$notFound} categories could not be mapped");
        }
        $this->info('Category fix complete!');
    }
}
