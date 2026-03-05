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

        $dummyProducts = [
            [
                'data' => [
                    'name' => 'Everyday Essential Tee',
                    'description' => 'Soft, breathable cotton tee built for daily comfort and easy layering.',
                    'category' => 't-shirt',
                    'fit_type' => 'normal',
                    'sleeve_type' => 'half',
                    'base_price' => 24.99,
                    'is_limited_edition' => false,
                    'drop_month' => 'March 2026',
                    'stock_limit' => null,
                    'is_active' => true,
                ],
                'sizes' => ['s', 'm', 'l', 'xl'],
                'colors' => [
                    ['name' => 'Cloud White', 'hex' => '#F5F5F5'],
                    ['name' => 'Graphite', 'hex' => '#2F2F2F'],
                ],
            ],
            [
                'data' => [
                    'name' => 'Washed Black Tee',
                    'description' => 'Vintage-wash finish with a worn-in feel from day one.',
                    'category' => 't-shirt',
                    'fit_type' => 'slight_oversize',
                    'sleeve_type' => 'half',
                    'base_price' => 32.50,
                    'is_limited_edition' => false,
                    'drop_month' => 'April 2026',
                    'stock_limit' => null,
                    'is_active' => true,
                ],
                'sizes' => ['m', 'l', 'xl', 'xxl'],
                'colors' => [
                    ['name' => 'Washed Black', 'hex' => '#1C1C1C'],
                ],
            ],
            [
                'data' => [
                    'name' => 'Coastal Breeze Tee',
                    'description' => 'Lightweight jersey with a crisp coastal palette.',
                    'category' => 't-shirt',
                    'fit_type' => 'normal',
                    'sleeve_type' => 'half',
                    'base_price' => 27.00,
                    'is_limited_edition' => false,
                    'drop_month' => 'May 2026',
                    'stock_limit' => null,
                    'is_active' => true,
                ],
                'sizes' => ['xs', 's', 'm', 'l'],
                'colors' => [
                    ['name' => 'Sea Mist', 'hex' => '#B0E0E6'],
                    ['name' => 'Deep Navy', 'hex' => '#001F3F'],
                ],
            ],
            [
                'data' => [
                    'name' => 'Studio Crew Tee',
                    'description' => 'Minimalist crew tee with premium stitching and clean lines.',
                    'category' => 't-shirt',
                    'fit_type' => 'normal',
                    'sleeve_type' => 'half',
                    'base_price' => 29.00,
                    'is_limited_edition' => false,
                    'drop_month' => 'June 2026',
                    'stock_limit' => null,
                    'is_active' => true,
                ],
                'sizes' => ['s', 'm', 'l', 'xl'],
                'colors' => [
                    ['name' => 'Stone', 'hex' => '#C2B280'],
                    ['name' => 'Ink', 'hex' => '#1A1A1A'],
                ],
            ],
            [
                'data' => [
                    'name' => 'Athletic Raglan Tee',
                    'description' => 'Raglan sleeves with flexible movement and durable seams.',
                    'category' => 't-shirt',
                    'fit_type' => 'normal',
                    'sleeve_type' => 'half',
                    'base_price' => 31.00,
                    'is_limited_edition' => false,
                    'drop_month' => 'July 2026',
                    'stock_limit' => null,
                    'is_active' => true,
                ],
                'sizes' => ['s', 'm', 'l', 'xl'],
                'colors' => [
                    ['name' => 'Heather Gray', 'hex' => '#B6B6B6'],
                    ['name' => 'Charcoal', 'hex' => '#36454F'],
                ],
            ],
            [
                'data' => [
                    'name' => 'Sunset Fade Tee',
                    'description' => 'Warm gradient tones inspired by late summer skies.',
                    'category' => 't-shirt',
                    'fit_type' => 'slight_oversize',
                    'sleeve_type' => 'half',
                    'base_price' => 35.00,
                    'is_limited_edition' => false,
                    'drop_month' => 'August 2026',
                    'stock_limit' => null,
                    'is_active' => true,
                ],
                'sizes' => ['m', 'l', 'xl'],
                'colors' => [
                    ['name' => 'Sunset Orange', 'hex' => '#FD5E53'],
                ],
            ],
            [
                'data' => [
                    'name' => 'Trail Pack Socks',
                    'description' => 'Cushioned crew socks for all-day wear and easy layering.',
                    'category' => 'accessories',
                    'fit_type' => 'normal',
                    'sleeve_type' => 'half',
                    'base_price' => 14.99,
                    'is_limited_edition' => false,
                    'drop_month' => 'September 2026',
                    'stock_limit' => null,
                    'is_active' => true,
                ],
                'sizes' => ['m'],
                'colors' => [
                    ['name' => 'Forest', 'hex' => '#228B22'],
                    ['name' => 'Cinder', 'hex' => '#4B4B4B'],
                ],
            ],
            [
                'data' => [
                    'name' => 'Canvas Tote',
                    'description' => 'Durable canvas tote with reinforced handles and roomy storage.',
                    'category' => 'accessories',
                    'fit_type' => 'normal',
                    'sleeve_type' => 'half',
                    'base_price' => 22.00,
                    'is_limited_edition' => false,
                    'drop_month' => 'October 2026',
                    'stock_limit' => null,
                    'is_active' => true,
                ],
                'sizes' => ['m'],
                'colors' => [
                    ['name' => 'Natural', 'hex' => '#EDE6D6'],
                    ['name' => 'Olive', 'hex' => '#556B2F'],
                ],
            ],
            [
                'data' => [
                    'name' => 'Everyday Crewneck',
                    'description' => 'Soft mid-weight crewneck for layering across seasons.',
                    'category' => 't-shirt',
                    'fit_type' => 'normal',
                    'sleeve_type' => 'full',
                    'base_price' => 52.00,
                    'is_limited_edition' => false,
                    'drop_month' => 'November 2026',
                    'stock_limit' => null,
                    'is_active' => true,
                ],
                'sizes' => ['s', 'm', 'l', 'xl'],
                'colors' => [
                    ['name' => 'Oat', 'hex' => '#E3D5B8'],
                    ['name' => 'Black', 'hex' => '#000000'],
                ],
            ],
            [
                'data' => [
                    'name' => 'City Stripe Tee',
                    'description' => 'Stripe pattern inspired by metro lines and modern grids.',
                    'category' => 't-shirt',
                    'fit_type' => 'normal',
                    'sleeve_type' => 'half',
                    'base_price' => 33.00,
                    'is_limited_edition' => false,
                    'drop_month' => 'December 2026',
                    'stock_limit' => null,
                    'is_active' => true,
                ],
                'sizes' => ['s', 'm', 'l', 'xl'],
                'colors' => [
                    ['name' => 'Slate', 'hex' => '#708090'],
                    ['name' => 'Off White', 'hex' => '#FAF9F6'],
                ],
            ],
        ];

        foreach ($dummyProducts as $item) {
            $product = Product::create(array_merge($item['data'], [
                'created_by' => $admin->id ?? 1,
            ]));

            foreach ($item['sizes'] as $size) {
                ProductSize::create([
                    'product_id' => $product->id,
                    'size' => $size,
                    'stock_quantity' => rand(12, 60),
                    'is_available' => true,
                ]);
            }

            foreach ($item['colors'] as $colorData) {
                ProductColor::create([
                    'product_id' => $product->id,
                    'color_name' => $colorData['name'],
                    'hex_code' => $colorData['hex'],
                    'is_active' => true,
                ]);
            }
        }

        $limitedAccessories = [
            [
                'data' => [
                    'name' => 'Aurora Knit Beanie',
                    'description' => 'Limited beanie with a soft glow-inspired palette and premium knit.',
                    'category' => 'accessories',
                    'fit_type' => 'normal',
                    'sleeve_type' => 'full',
                    'base_price' => 34.00,
                    'is_limited_edition' => true,
                    'drop_month' => 'March 2026',
                    'drop_name' => 'Northern Light',
                    'drop_story' => 'A soft spectrum of color drawn from the aurora borealis.',
                    'drop_start_at' => now()->addDays(3),
                    'drop_end_at' => now()->addDays(10),
                    'quantity_limit' => 60,
                    'countdown_enabled' => true,
                    'auto_hide_out_of_stock' => true,
                    'stock_limit' => 60,
                    'is_active' => true,
                ],
                'sizes' => ['m'],
                'colors' => [
                    ['name' => 'Aurora Green', 'hex' => '#7FFFD4'],
                    ['name' => 'Midnight', 'hex' => '#191970'],
                ],
            ],
            [
                'data' => [
                    'name' => 'Atlas Field Cap',
                    'description' => 'Limited cap with a structured crown and subtle crest embroidery.',
                    'category' => 'accessories',
                    'fit_type' => 'normal',
                    'sleeve_type' => 'half',
                    'base_price' => 36.00,
                    'is_limited_edition' => true,
                    'drop_month' => 'March 2026',
                    'drop_name' => 'Atlas',
                    'drop_story' => 'Mapped by hand, inspired by expedition charts and bold routes.',
                    'drop_start_at' => now()->subDays(1),
                    'drop_end_at' => now()->addDays(6),
                    'quantity_limit' => 80,
                    'countdown_enabled' => true,
                    'auto_hide_out_of_stock' => true,
                    'stock_limit' => 80,
                    'is_active' => true,
                ],
                'sizes' => ['m'],
                'colors' => [
                    ['name' => 'Sand', 'hex' => '#CBB292'],
                    ['name' => 'Ink Black', 'hex' => '#0B0B0B'],
                ],
            ],
            [
                'data' => [
                    'name' => 'Orbit Crossbody Bag',
                    'description' => 'Limited crossbody with modular pockets and sleek hardware.',
                    'category' => 'accessories',
                    'fit_type' => 'normal',
                    'sleeve_type' => 'half',
                    'base_price' => 54.00,
                    'is_limited_edition' => true,
                    'drop_month' => 'April 2026',
                    'drop_name' => 'Orbit',
                    'drop_story' => 'Designed for daily rotation with space-age utility.',
                    'drop_start_at' => now()->addDays(5),
                    'drop_end_at' => now()->addDays(12),
                    'quantity_limit' => 70,
                    'countdown_enabled' => true,
                    'auto_hide_out_of_stock' => true,
                    'stock_limit' => 70,
                    'is_active' => true,
                ],
                'sizes' => ['m'],
                'colors' => [
                    ['name' => 'Carbon', 'hex' => '#2C2C2C'],
                    ['name' => 'Signal Red', 'hex' => '#D32F2F'],
                ],
            ],
            [
                'data' => [
                    'name' => 'Cinder Leather Wallet',
                    'description' => 'Slim limited wallet in smooth leather with contrast stitching.',
                    'category' => 'accessories',
                    'fit_type' => 'normal',
                    'sleeve_type' => 'half',
                    'base_price' => 48.00,
                    'is_limited_edition' => true,
                    'drop_month' => 'April 2026',
                    'drop_name' => 'Cinder',
                    'drop_story' => 'Ash tones and burnished textures inspired by city nights.',
                    'drop_start_at' => now()->subDays(4),
                    'drop_end_at' => now()->addDays(3),
                    'quantity_limit' => 50,
                    'countdown_enabled' => true,
                    'auto_hide_out_of_stock' => true,
                    'stock_limit' => 50,
                    'is_active' => true,
                ],
                'sizes' => ['m'],
                'colors' => [
                    ['name' => 'Cinder', 'hex' => '#4A4A4A'],
                ],
            ],
            [
                'data' => [
                    'name' => 'Tide Runner Sunglasses',
                    'description' => 'Limited acetate frames with ocean-tinted lenses.',
                    'category' => 'accessories',
                    'fit_type' => 'normal',
                    'sleeve_type' => 'half',
                    'base_price' => 62.00,
                    'is_limited_edition' => true,
                    'drop_month' => 'May 2026',
                    'drop_name' => 'Tide Runner',
                    'drop_story' => 'Sunlit horizons and fast tides captured in a sleek frame.',
                    'drop_start_at' => now()->addDays(9),
                    'drop_end_at' => now()->addDays(16),
                    'quantity_limit' => 90,
                    'countdown_enabled' => true,
                    'auto_hide_out_of_stock' => true,
                    'stock_limit' => 90,
                    'is_active' => true,
                ],
                'sizes' => ['m'],
                'colors' => [
                    ['name' => 'Ocean Blue', 'hex' => '#1E88E5'],
                    ['name' => 'Smoke', 'hex' => '#6D6D6D'],
                ],
            ],
            [
                'data' => [
                    'name' => 'Voltage Keychain',
                    'description' => 'Limited anodized keychain with electric finish.',
                    'category' => 'accessories',
                    'fit_type' => 'normal',
                    'sleeve_type' => 'half',
                    'base_price' => 18.00,
                    'is_limited_edition' => true,
                    'drop_month' => 'May 2026',
                    'drop_name' => 'Voltage',
                    'drop_story' => 'A charge of color and metallic detail for everyday carry.',
                    'drop_start_at' => now()->subDays(2),
                    'drop_end_at' => now()->addDays(5),
                    'quantity_limit' => 120,
                    'countdown_enabled' => true,
                    'auto_hide_out_of_stock' => true,
                    'stock_limit' => 120,
                    'is_active' => true,
                ],
                'sizes' => ['m'],
                'colors' => [
                    ['name' => 'Electric Blue', 'hex' => '#00B0FF'],
                    ['name' => 'Neon Lime', 'hex' => '#BFFF00'],
                ],
            ],
            [
                'data' => [
                    'name' => 'Quartz Travel Mug',
                    'description' => 'Limited travel mug with double-wall insulation.',
                    'category' => 'accessories',
                    'fit_type' => 'normal',
                    'sleeve_type' => 'full',
                    'base_price' => 44.00,
                    'is_limited_edition' => true,
                    'drop_month' => 'June 2026',
                    'drop_name' => 'Quartz',
                    'drop_story' => 'Clean lines and translucent tones inspired by crystal forms.',
                    'drop_start_at' => now()->addDays(12),
                    'drop_end_at' => now()->addDays(19),
                    'quantity_limit' => 65,
                    'countdown_enabled' => true,
                    'auto_hide_out_of_stock' => true,
                    'stock_limit' => 65,
                    'is_active' => true,
                ],
                'sizes' => ['m'],
                'colors' => [
                    ['name' => 'Frost', 'hex' => '#E8F1F2'],
                    ['name' => 'Slate Blue', 'hex' => '#6A5ACD'],
                ],
            ],
            [
                'data' => [
                    'name' => 'Summit Rope Bracelet',
                    'description' => 'Limited braided bracelet with anodized clasp.',
                    'category' => 'accessories',
                    'fit_type' => 'normal',
                    'sleeve_type' => 'half',
                    'base_price' => 26.00,
                    'is_limited_edition' => true,
                    'drop_month' => 'June 2026',
                    'drop_name' => 'Summit',
                    'drop_story' => 'Outdoor grit and bright metal accents for bold carry.',
                    'drop_start_at' => now()->subDays(5),
                    'drop_end_at' => now()->addDays(2),
                    'quantity_limit' => 110,
                    'countdown_enabled' => true,
                    'auto_hide_out_of_stock' => true,
                    'stock_limit' => 110,
                    'is_active' => true,
                ],
                'sizes' => ['m'],
                'colors' => [
                    ['name' => 'Crimson', 'hex' => '#DC143C'],
                    ['name' => 'Midnight', 'hex' => '#101820'],
                ],
            ],
            [
                'data' => [
                    'name' => 'Drift Tech Pouch',
                    'description' => 'Limited utility pouch for tech and travel essentials.',
                    'category' => 'accessories',
                    'fit_type' => 'normal',
                    'sleeve_type' => 'half',
                    'base_price' => 38.00,
                    'is_limited_edition' => true,
                    'drop_month' => 'July 2026',
                    'drop_name' => 'Drift',
                    'drop_story' => 'Balanced storage and smooth glide fabrics in a compact form.',
                    'drop_start_at' => now()->addDays(15),
                    'drop_end_at' => now()->addDays(22),
                    'quantity_limit' => 75,
                    'countdown_enabled' => true,
                    'auto_hide_out_of_stock' => true,
                    'stock_limit' => 75,
                    'is_active' => true,
                ],
                'sizes' => ['m'],
                'colors' => [
                    ['name' => 'Moss', 'hex' => '#556B2F'],
                    ['name' => 'Stone', 'hex' => '#8D8D8D'],
                ],
            ],
            [
                'data' => [
                    'name' => 'Halo Enamel Pin Set',
                    'description' => 'Limited enamel pin set with metallic finish.',
                    'category' => 'accessories',
                    'fit_type' => 'normal',
                    'sleeve_type' => 'half',
                    'base_price' => 20.00,
                    'is_limited_edition' => true,
                    'drop_month' => 'July 2026',
                    'drop_name' => 'Halo',
                    'drop_story' => 'Clean, iconic shapes with subtle shine and detail.',
                    'drop_start_at' => now()->subDays(3),
                    'drop_end_at' => now()->addDays(4),
                    'quantity_limit' => 140,
                    'countdown_enabled' => true,
                    'auto_hide_out_of_stock' => true,
                    'stock_limit' => 140,
                    'is_active' => true,
                ],
                'sizes' => ['m'],
                'colors' => [
                    ['name' => 'Gold', 'hex' => '#D4AF37'],
                    ['name' => 'Silver', 'hex' => '#C0C0C0'],
                ],
            ],
        ];

        foreach ($limitedAccessories as $item) {
            $product = Product::create(array_merge($item['data'], [
                'created_by' => $admin->id ?? 1,
            ]));

            foreach ($item['sizes'] as $size) {
                ProductSize::create([
                    'product_id' => $product->id,
                    'size' => $size,
                    'stock_quantity' => rand(10, 40),
                    'is_available' => true,
                ]);
            }

            foreach ($item['colors'] as $colorData) {
                ProductColor::create([
                    'product_id' => $product->id,
                    'color_name' => $colorData['name'],
                    'hex_code' => $colorData['hex'],
                    'is_active' => true,
                ]);
            }
        }
    }
}
