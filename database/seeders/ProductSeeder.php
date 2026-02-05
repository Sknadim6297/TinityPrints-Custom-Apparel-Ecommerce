<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\ProductSize;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Admin::first(); // Get the first admin user

        // Product 1: Classic White T-Shirt
        $product1 = Product::create([
            'name' => 'Classic White T-Shirt',
            'description' => 'A timeless white t-shirt made from premium cotton. Perfect for everyday wear with a comfortable fit that lasts.',
            'category' => 't-shirt',
            'fit_type' => 'normal',
            'sleeve_type' => 'half',
            'base_price' => 29.99,
            'is_limited_edition' => false,
            'drop_month' => 'March 2026',
            'stock_limit' => null,
            'is_active' => true,
            'created_by' => $admin->id ?? 1,
        ]);

        // Add sizes for product 1
        $sizes1 = ['s', 'm', 'l', 'xl', 'xxl'];
        foreach ($sizes1 as $size) {
            ProductSize::create([
                'product_id' => $product1->id,
                'size' => $size,
                'stock_quantity' => rand(10, 50),
                'is_available' => true,
            ]);
        }

        // Add color for product 1
        $color1 = ProductColor::create([
            'product_id' => $product1->id,
            'color_name' => 'White',
            'hex_code' => '#FFFFFF',
            'is_active' => true,
        ]);

        // Product 2: Limited Edition Black Hoodie - Updated with drop controls
        $product2 = Product::create([
            'name' => 'Limited Edition Black Hoodie',
            'description' => 'Exclusive black hoodie with unique design elements. Limited stock available - get yours before it\'s gone!',
            'category' => 't-shirt',
            'fit_type' => 'slight_oversize',
            'sleeve_type' => 'full',
            'base_price' => 79.99,
            'is_limited_edition' => true,
            'drop_month' => 'February 2026',
            'drop_name' => 'Midnight Eclipse',
            'drop_story' => 'Inspired by the rare celestial event of a total lunar eclipse, this hoodie captures the mysterious beauty of the night sky. Each piece tells a story of cosmic wonder and earthly connection.',
            'drop_start_at' => now()->addDays(7), // Starts in 7 days
            'drop_end_at' => now()->addDays(14), // Ends in 14 days
            'quantity_limit' => 100,
            'countdown_enabled' => true,
            'auto_hide_out_of_stock' => true,
            'stock_limit' => 100,
            'is_active' => true,
            'created_by' => $admin->id ?? 1,
        ]);

        // Add sizes for product 2
        $sizes2 = ['m', 'l', 'xl'];
        foreach ($sizes2 as $size) {
            ProductSize::create([
                'product_id' => $product2->id,
                'size' => $size,
                'stock_quantity' => rand(5, 15),
                'is_available' => true,
            ]);
        }

        // Add color for product 2
        $color2 = ProductColor::create([
            'product_id' => $product2->id,
            'color_name' => 'Black',
            'hex_code' => '#000000',
            'is_active' => true,
        ]);

        // Product 3: Navy Blue T-Shirt
        $product3 = Product::create([
            'name' => 'Navy Blue T-Shirt',
            'description' => 'Stylish navy blue t-shirt with a modern cut. Perfect for casual outings and everyday comfort.',
            'category' => 't-shirt',
            'fit_type' => 'normal',
            'sleeve_type' => 'half',
            'base_price' => 34.99,
            'is_limited_edition' => false,
            'drop_month' => 'April 2026',
            'stock_limit' => null,
            'is_active' => true,
            'created_by' => $admin->id ?? 1,
        ]);

        // Add sizes for product 3
        $sizes3 = ['xs', 's', 'm', 'l', 'xl'];
        foreach ($sizes3 as $size) {
            ProductSize::create([
                'product_id' => $product3->id,
                'size' => $size,
                'stock_quantity' => rand(8, 25),
                'is_available' => true,
            ]);
        }

        // Add color for product 3
        $color3 = ProductColor::create([
            'product_id' => $product3->id,
            'color_name' => 'Navy Blue',
            'hex_code' => '#000080',
            'is_active' => true,
        ]);

        // Product 4: Premium Beanie
        $product4 = Product::create([
            'name' => 'Premium Wool Beanie',
            'description' => 'Warm and stylish wool beanie perfect for cold weather. Made from high-quality materials for maximum comfort.',
            'category' => 'accessories',
            'fit_type' => 'normal',
            'sleeve_type' => 'full',
            'base_price' => 24.99,
            'is_limited_edition' => false,
            'drop_month' => 'December 2025',
            'stock_limit' => null,
            'is_active' => true,
            'created_by' => $admin->id ?? 1,
        ]);

        // Add sizes for product 4 (beanies typically have one size or a few)
        ProductSize::create([
            'product_id' => $product4->id,
            'size' => 'm',
            'stock_quantity' => 30,
            'is_available' => true,
        ]);

        // Add colors for product 4
        $beanieColors = [
            ['name' => 'Gray', 'hex' => '#808080'],
            ['name' => 'Black', 'hex' => '#000000'],
        ];

        foreach ($beanieColors as $colorData) {
            ProductColor::create([
                'product_id' => $product4->id,
                'color_name' => $colorData['name'],
                'hex_code' => $colorData['hex'],
                'is_active' => true,
            ]);
        }

        // Product 5: Vintage Style Cap
        $product5 = Product::create([
            'name' => 'Vintage Style Baseball Cap',
            'description' => 'Classic baseball cap with vintage-inspired design. Adjustable fit for maximum comfort.',
            'category' => 'accessories',
            'fit_type' => 'normal',
            'sleeve_type' => 'half',
            'base_price' => 19.99,
            'is_limited_edition' => false,
            'drop_month' => 'May 2026',
            'stock_limit' => null,
            'is_active' => true,
            'created_by' => $admin->id ?? 1,
        ]);

        // Add sizes for product 5 (caps typically have one size)
        ProductSize::create([
            'product_id' => $product5->id,
            'size' => 'm',
            'stock_quantity' => 40,
            'is_available' => true,
        ]);

        // Add colors for product 5
        $capColors = [
            ['name' => 'Navy', 'hex' => '#000080'],
            ['name' => 'Khaki', 'hex' => '#F0E68C'],
            ['name' => 'Black', 'hex' => '#000000'],
        ];

        foreach ($capColors as $colorData) {
            ProductColor::create([
                'product_id' => $product5->id,
                'color_name' => $colorData['name'],
                'hex_code' => $colorData['hex'],
                'is_active' => true,
            ]);
        }

        // Product 6: Limited Edition "Neon Dreams" T-Shirt - Upcoming Drop
        $product6 = Product::create([
            'name' => 'Neon Dreams T-Shirt',
            'description' => 'Vibrant neon colors that light up your style. A celebration of urban energy and nightlife culture.',
            'category' => 't-shirt',
            'fit_type' => 'normal',
            'sleeve_type' => 'half',
            'base_price' => 39.99,
            'is_limited_edition' => true,
            'drop_month' => 'March 2026',
            'drop_name' => 'Neon Dreams',
            'drop_story' => 'Step into the electric glow of city lights with our Neon Dreams collection. Inspired by the pulsating energy of urban nightlife, this drop captures the vibrant spirit of those who live for the night and dream in color.',
            'drop_start_at' => now()->addDays(14), // Starts in 14 days
            'drop_end_at' => now()->addDays(21), // Ends in 21 days
            'quantity_limit' => 200,
            'countdown_enabled' => true,
            'auto_hide_out_of_stock' => false,
            'stock_limit' => 200,
            'is_active' => true,
            'created_by' => $admin->id ?? 1,
        ]);

        // Add sizes for product 6
        $sizes6 = ['s', 'm', 'l', 'xl', 'xxl'];
        foreach ($sizes6 as $size) {
            ProductSize::create([
                'product_id' => $product6->id,
                'size' => $size,
                'stock_quantity' => rand(8, 20),
                'is_available' => true,
            ]);
        }

        // Add colors for product 6
        $neonColors = [
            ['name' => 'Electric Blue', 'hex' => '#00FFFF'],
            ['name' => 'Hot Pink', 'hex' => '#FF1493'],
            ['name' => 'Lime Green', 'hex' => '#32CD32'],
        ];

        foreach ($neonColors as $colorData) {
            ProductColor::create([
                'product_id' => $product6->id,
                'color_name' => $colorData['name'],
                'hex_code' => $colorData['hex'],
                'is_active' => true,
            ]);
        }

        // Product 7: Limited Edition "Arctic Fox" Hoodie - Past Drop (Ended)
        $product7 = Product::create([
            'name' => 'Arctic Fox Hoodie',
            'description' => 'Inspired by the elusive arctic fox, this hoodie represents resilience and adaptability in harsh conditions.',
            'category' => 't-shirt',
            'fit_type' => 'slight_oversize',
            'sleeve_type' => 'full',
            'base_price' => 89.99,
            'is_limited_edition' => true,
            'drop_month' => 'January 2026',
            'drop_name' => 'Arctic Expedition',
            'drop_story' => 'Journey to the frozen north with our Arctic Expedition collection. Drawing inspiration from the majestic arctic fox, this drop celebrates survival, beauty, and the quiet strength found in extreme environments.',
            'drop_start_at' => now()->subDays(10), // Started 10 days ago
            'drop_end_at' => now()->subDays(3), // Ended 3 days ago
            'quantity_limit' => 150,
            'countdown_enabled' => false,
            'auto_hide_out_of_stock' => true,
            'stock_limit' => 150,
            'is_active' => false, // Auto-hidden due to stock = 0
            'created_by' => $admin->id ?? 1,
        ]);

        // Add sizes for product 7 (out of stock)
        $sizes7 = ['s', 'm', 'l', 'xl'];
        foreach ($sizes7 as $size) {
            ProductSize::create([
                'product_id' => $product7->id,
                'size' => $size,
                'stock_quantity' => 0, // Out of stock
                'is_available' => true,
            ]);
        }

        // Add color for product 7
        ProductColor::create([
            'product_id' => $product7->id,
            'color_name' => 'Arctic White',
            'hex_code' => '#F8F8FF',
            'is_active' => true,
        ]);

        // Product 8: Limited Edition "Solar Flare" Cap - Active Drop
        $product8 = Product::create([
            'name' => 'Solar Flare Baseball Cap',
            'description' => 'Bold and energetic cap inspired by solar flares. Perfect for those who shine bright and stand out.',
            'category' => 'accessories',
            'fit_type' => 'normal',
            'sleeve_type' => 'half',
            'base_price' => 29.99,
            'is_limited_edition' => true,
            'drop_month' => 'February 2026',
            'drop_name' => 'Solar Flare',
            'drop_story' => 'Harness the power of the sun with our Solar Flare collection. Inspired by the explosive beauty of solar phenomena, this drop radiates energy and warmth for those who light up every room they enter.',
            'drop_start_at' => now()->subDays(2), // Started 2 days ago
            'drop_end_at' => now()->addDays(5), // Ends in 5 days
            'quantity_limit' => 75,
            'countdown_enabled' => true,
            'auto_hide_out_of_stock' => true,
            'stock_limit' => 75,
            'is_active' => true,
            'created_by' => $admin->id ?? 1,
        ]);

        // Add sizes for product 8
        ProductSize::create([
            'product_id' => $product8->id,
            'size' => 'm',
            'stock_quantity' => 23, // Some stock remaining
            'is_available' => true,
        ]);

        // Add colors for product 8
        $flareColors = [
            ['name' => 'Sunset Orange', 'hex' => '#FF4500'],
            ['name' => 'Golden Yellow', 'hex' => '#FFD700'],
        ];

        foreach ($flareColors as $colorData) {
            ProductColor::create([
                'product_id' => $product8->id,
                'color_name' => $colorData['name'],
                'hex_code' => $colorData['hex'],
                'is_active' => true,
            ]);
        }
    }
}
