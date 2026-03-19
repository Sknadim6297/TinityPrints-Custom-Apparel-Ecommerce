<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;

class ListCategories extends Command
{
    protected $signature = 'products:list-categories';

    protected $description = 'List all categories and their IDs';

    public function handle()
    {
        $this->info('=== All Categories ===');
        $categories = Category::all();

        foreach ($categories as $cat) {
            $this->line("ID: {$cat->id} | Name: {$cat->name} | Slug: {$cat->slug}");
        }

        // Now fix mismatched products
        $this->info("\n=== Checking for Mismatched Products ===");
        
        $products = Product::where('category', '!=', '')->whereNotNull('category_id')->get();

        $fixed = 0;
        foreach ($products as $product) {
            $category = Category::find($product->category_id);
            if ($category && $product->category !== $category->slug) {
                $this->warn("MISMATCH: Product {$product->id} has category string '{$product->category}' but category_id points to '{$category->slug}'");
                $product->update(['category' => $category->slug]);
                $fixed++;
                $this->line("✓ Fixed to: '{$category->slug}'");
            }
        }

        $this->info("\n✓ Fixed {$fixed} mismatched products");
    }
}
