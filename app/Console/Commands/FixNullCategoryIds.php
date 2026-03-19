<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Console\Command;

class FixNullCategoryIds extends Command
{
    protected $signature = 'products:fix-null-categories';

    protected $description = 'Fix products with NULL category_id by looking up the correct category';

    public function handle()
    {
        $this->info('=== Checking for Products with NULL category_id ===');

        $products = Product::whereNull('category_id')
            ->where('category', '!=', '')
            ->whereNotNull('category')
            ->get();

        if ($products->count() === 0) {
            $this->info('✓ No products with NULL category_id found!');
            return;
        }

        $this->warn('Found ' . $products->count() . ' products with NULL category_id');

        $fixed = 0;
        foreach ($products as $product) {
            // Find category by string value
            $category = Category::query()
                ->where(function ($query) use ($product) {
                    $query->where('slug', $product->category)
                          ->orWhereRaw('LOWER(name) = ?', [strtolower(str_replace('-', ' ', $product->category))]);
                })
                ->first();

            if ($category) {
                $product->update(['category_id' => $category->id]);
                $this->line("✓ Product {$product->id} ({$product->name}) → Category ID {$category->id}");
                $fixed++;
            } else {
                $this->warn("✗ Product {$product->id} - Could not find category for '{$product->category}'");
            }
        }

        $this->info("\n✓ Fixed {$fixed} products with NULL category_id");

        // Now show all products with their categories
        $this->info("\n=== All Products with Categories ===");
        $allProducts = Product::with('category')
            ->where('is_active', true)
            ->orderBy('category')
            ->get(['id', 'name', 'category', 'category_id']);

        foreach ($allProducts as $product) {
            $catName = $product->category?->name ?? 'NULL';
            $this->line("{$product->id} | {$product->name} | {$product->category} | ID:{$product->category_id} | Relation:{$catName}");
        }
    }
}
