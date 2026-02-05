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

        // Product 2: Limited Edition Black Hoodie
        $product2 = Product::create([
            'name' => 'Limited Edition Black Hoodie',
            'description' => 'Exclusive black hoodie with unique design elements. Limited stock available - get yours before it\'s gone!',
            'category' => 't-shirt',
            'fit_type' => 'slight_oversize',
            'sleeve_type' => 'full',
            'base_price' => 79.99,
            'is_limited_edition' => true,
            'drop_month' => 'February 2026',
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
    }
}
