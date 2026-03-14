<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Category;
use App\Models\CollectionType;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\ProductSize;
use App\Models\SleeveType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ShopWomenDummyProductSeeder extends Seeder
{
    public function run(): void
    {
        $adminId = Admin::query()->value('id') ?? 1;

        $womenCategory = Category::query()->firstOrCreate(
            ['slug' => 'women'],
            [
                'name' => 'Women',
                'description' => 'Women category for shop listing demo products.',
                'is_active' => true,
                'created_by' => $adminId,
            ]
        );

        $halfSleeve = SleeveType::query()->firstOrCreate(
            ['slug' => 'half-sleeve'],
            [
                'name' => 'Half Sleeve',
                'description' => 'Half sleeve styles',
                'is_active' => true,
                'created_by' => $adminId,
            ]
        );

        $fullSleeve = SleeveType::query()->firstOrCreate(
            ['slug' => 'full-sleeve'],
            [
                'name' => 'Full Sleeve',
                'description' => 'Full sleeve styles',
                'is_active' => true,
                'created_by' => $adminId,
            ]
        );

        $everydayCollection = CollectionType::query()->firstOrCreate(
            ['slug' => 'everyday-essentials'],
            [
                'name' => 'Everyday Essentials',
                'description' => 'Daily wear essentials collection.',
                'is_active' => true,
                'created_by' => $adminId,
            ]
        );

        $statementCollection = CollectionType::query()->firstOrCreate(
            ['slug' => 'statement-pieces'],
            [
                'name' => 'Statement Pieces',
                'description' => 'Bold and standout products.',
                'is_active' => true,
                'created_by' => $adminId,
            ]
        );

        $products = [
            [
                'name' => 'Black Wide-Leg Sweatpants',
                'base_price' => 999.00,
                'category' => 'accessories',
                'fit_type' => 'oversize',
                'sleeve_type' => 'full',
                'sleeve_type_id' => $fullSleeve->id,
                'collection_type_id' => $everydayCollection->id,
                'is_limited_edition' => false,
                'drop_story' => null,
                'colors' => [['name' => 'Black', 'hex' => '#000000']],
            ],
            [
                'name' => 'Sand Beige Wide-Leg Sweatpants',
                'base_price' => 999.00,
                'category' => 'accessories',
                'fit_type' => 'oversize',
                'sleeve_type' => 'full',
                'sleeve_type_id' => $fullSleeve->id,
                'collection_type_id' => $everydayCollection->id,
                'is_limited_edition' => false,
                'drop_story' => null,
                'colors' => [['name' => 'Sand Beige', 'hex' => '#D8C3A5']],
            ],
            [
                'name' => 'Dark Shadow Wide-Leg Sweatpants',
                'base_price' => 999.00,
                'category' => 'accessories',
                'fit_type' => 'oversize',
                'sleeve_type' => 'full',
                'sleeve_type_id' => $fullSleeve->id,
                'collection_type_id' => $statementCollection->id,
                'is_limited_edition' => true,
                'drop_story' => 'A moody streetwear drop inspired by urban shadows and night motion.',
                'colors' => [['name' => 'Dark Grey', 'hex' => '#444444']],
            ],
            [
                'name' => 'Grey Melange Wide-Leg',
                'base_price' => 999.00,
                'category' => 'accessories',
                'fit_type' => 'oversize',
                'sleeve_type' => 'full',
                'sleeve_type_id' => $fullSleeve->id,
                'collection_type_id' => $everydayCollection->id,
                'is_limited_edition' => false,
                'drop_story' => null,
                'colors' => [['name' => 'Grey', 'hex' => '#808080']],
            ],
            [
                'name' => "Founder's Jacket",
                'base_price' => 2999.00,
                'category' => 'accessories',
                'fit_type' => 'regular',
                'sleeve_type' => 'full',
                'sleeve_type_id' => $fullSleeve->id,
                'collection_type_id' => $statementCollection->id,
                'is_limited_edition' => true,
                'drop_story' => 'Founder inspired premium outerwear with bold structure and minimal finish.',
                'colors' => [['name' => 'Brown', 'hex' => '#5C4033']],
            ],
            [
                'name' => 'Blue Static Fade Joggers',
                'base_price' => 1399.00,
                'category' => 'accessories',
                'fit_type' => 'regular',
                'sleeve_type' => 'full',
                'sleeve_type_id' => $fullSleeve->id,
                'collection_type_id' => $everydayCollection->id,
                'is_limited_edition' => false,
                'drop_story' => null,
                'colors' => [['name' => 'Blue', 'hex' => '#1E3A8A']],
            ],
            [
                'name' => 'Grey Pleated Skirt',
                'base_price' => 1199.00,
                'category' => 'accessories',
                'fit_type' => 'regular',
                'sleeve_type' => 'half',
                'sleeve_type_id' => $halfSleeve->id,
                'collection_type_id' => $statementCollection->id,
                'is_limited_edition' => false,
                'drop_story' => null,
                'colors' => [['name' => 'Grey', 'hex' => '#808080']],
            ],
            [
                'name' => 'Black Pleated Skirt',
                'base_price' => 1199.00,
                'category' => 'accessories',
                'fit_type' => 'regular',
                'sleeve_type' => 'half',
                'sleeve_type_id' => $halfSleeve->id,
                'collection_type_id' => $statementCollection->id,
                'is_limited_edition' => false,
                'drop_story' => null,
                'colors' => [['name' => 'Black', 'hex' => '#000000']],
            ],
            [
                'name' => 'Crosstown Shoulder Bag',
                'base_price' => 1999.00,
                'category' => 'accessories',
                'fit_type' => 'normal',
                'sleeve_type' => 'half',
                'sleeve_type_id' => $halfSleeve->id,
                'collection_type_id' => $statementCollection->id,
                'is_limited_edition' => false,
                'drop_story' => 'Compact street utility bag built for city movement and everyday carry.',
                'colors' => [['name' => 'Black', 'hex' => '#111111']],
            ],
            [
                'name' => 'Shadow Petal Baby Tee',
                'base_price' => 699.00,
                'category' => 't-shirt',
                'fit_type' => 'regular',
                'sleeve_type' => 'half',
                'sleeve_type_id' => $halfSleeve->id,
                'collection_type_id' => $everydayCollection->id,
                'is_limited_edition' => false,
                'drop_story' => null,
                'colors' => [['name' => 'Black', 'hex' => '#1B1B1B']],
            ],
            [
                'name' => 'Playful Ninja Baby Tee',
                'base_price' => 699.00,
                'category' => 't-shirt',
                'fit_type' => 'regular',
                'sleeve_type' => 'half',
                'sleeve_type_id' => $halfSleeve->id,
                'collection_type_id' => $statementCollection->id,
                'is_limited_edition' => true,
                'drop_story' => 'Anime-inspired street drop with playful graphics and sharp contrast tones.',
                'colors' => [['name' => 'White', 'hex' => '#FFFFFF']],
            ],
            [
                'name' => 'Playboy In Pursuit Oversized T-shirt',
                'base_price' => 999.00,
                'category' => 't-shirt',
                'fit_type' => 'oversize',
                'sleeve_type' => 'half',
                'sleeve_type_id' => $halfSleeve->id,
                'collection_type_id' => $statementCollection->id,
                'is_limited_edition' => false,
                'drop_story' => null,
                'colors' => [['name' => 'Black', 'hex' => '#111111']],
            ],
        ];

        foreach ($products as $item) {
            $product = Product::query()->updateOrCreate(
                ['name' => $item['name']],
                [
                    'description' => $this->descriptionFor($item['name']),
                    'category' => $item['category'],
                    'category_id' => $womenCategory->id,
                    'brand' => 'Dummy Brand',
                    'fit_type' => $item['fit_type'],
                    'sleeve_type' => $item['sleeve_type'],
                    'sleeve_type_id' => $item['sleeve_type_id'],
                    'collection_type_id' => $item['collection_type_id'],
                    'base_price' => $item['base_price'],
                    'is_limited_edition' => $item['is_limited_edition'],
                    'drop_month' => now()->format('F Y'),
                    'drop_name' => $item['is_limited_edition'] ? Str::title(Str::slug($item['name'], ' ')) : null,
                    'drop_story' => $item['drop_story'],
                    'stock_limit' => null,
                    'is_active' => true,
                    'created_by' => $adminId,
                ]
            );

            foreach (['m', 'l'] as $size) {
                ProductSize::query()->updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'size' => $size,
                    ],
                    [
                        'stock_quantity' => 20,
                        'is_available' => true,
                    ]
                );
            }

            foreach ($item['colors'] as $color) {
                $productColor = ProductColor::query()->updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'color_name' => $color['name'],
                    ],
                    [
                        'hex_code' => $color['hex'],
                        'is_active' => true,
                    ]
                );

                $encodedName = rawurlencode($item['name']);
                $frontImageUrl = "https://via.placeholder.com/1000x1500?text={$encodedName}+Front";
                $backImageUrl = "https://via.placeholder.com/1000x1500?text={$encodedName}+Back";

                ProductImage::query()->updateOrCreate(
                    [
                        'product_color_id' => $productColor->id,
                        'image_type' => 'front',
                    ],
                    [
                        'image_path' => $frontImageUrl,
                    ]
                );

                ProductImage::query()->updateOrCreate(
                    [
                        'product_color_id' => $productColor->id,
                        'image_type' => 'back',
                    ],
                    [
                        'image_path' => $backImageUrl,
                    ]
                );
            }
        }
    }

    private function descriptionFor(string $name): string
    {
        return 'Dummy product for Shop Women carousel: ' . $name . '. Built for filter testing across category, sleeve type, collection type, size, color, edition, story, and stock.';
    }
}
