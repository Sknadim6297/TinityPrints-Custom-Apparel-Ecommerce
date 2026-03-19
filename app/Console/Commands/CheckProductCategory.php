<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class CheckProductCategory extends Command
{
    protected $signature = 'products:check-boombox';

    protected $description = 'Check the Boombox product category assignment';

    public function handle()
    {
        $product = Product::where('name', 'like', '%Boombox%')->first();

        if (!$product) {
            $this->warn('Boombox product not found!');
            return;
        }

        $this->info('=== Boombox Product Details ===');
        $this->line('ID: ' . $product->id);
        $this->line('Name: ' . $product->name);
        $this->line('Category String: ' . ($product->category ?? 'NULL'));
        $this->line('Category ID: ' . ($product->category_id ?? 'NULL'));
        
        if ($product->category_id) {
            $cat = $product->category()->first();
            $this->line('Category Relation: ' . ($cat?->name ?? 'NOT FOUND'));
            $this->line('Category Slug: ' . ($cat?->slug ?? 'N/A'));
        }

        $this->line('Fit Type: ' . ($product->fit_type ?? 'NULL'));
        $this->line('Sleeve Type: ' . ($product->sleeve_type ?? 'NULL'));
        $this->line('Sleeve Type ID: ' . ($product->sleeve_type_id ?? 'NULL'));
        $this->line('Collection Type ID: ' . ($product->collection_type_id ?? 'NULL'));
        $this->line('Is Limited Edition: ' . ($product->is_limited_edition ? 'YES' : 'NO'));
    }
}
