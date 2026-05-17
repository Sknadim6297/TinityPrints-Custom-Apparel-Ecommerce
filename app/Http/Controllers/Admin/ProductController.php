<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CollectionType;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Support\ImageOptimizer;
use App\Models\ProductSize;
use App\Models\SleeveType;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['colors.images', 'sizes', 'admin', 'category', 'sleeveType', 'collectionType']);

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('drop_name', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%");
            });
        }

        // Apply filters
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('sleeve_type_id')) {
            $query->where('sleeve_type_id', $request->sleeve_type_id);
        }

        if ($request->filled('collection_type_id')) {
            $query->where('collection_type_id', $request->collection_type_id);
        }

        if ($request->filled('size')) {
            $query->whereHas('sizes', function($q) use ($request) {
                $q->where('size', $request->size);
            });
        }

        if ($request->filled('color')) {
            $query->whereHas('colors', function($q) use ($request) {
                $q->whereRaw('LOWER(color_name) LIKE ?', ['%' . strtolower($request->color) . '%']);
            });
        }

        if ($request->filled('limited_edition')) {
            $query->where('is_limited_edition', $request->boolean('limited_edition'));
        }

        if ($request->filled('story')) {
            $query->whereNotNull('drop_story')->where('drop_story', '!=', '');
        }

        if ($request->filled('stock_status')) {
            if ($request->stock_status === 'in_stock') {
                $query->whereHas('sizes', function ($subQuery) {
                    $subQuery->where('stock_quantity', '>', 0);
                });
            }

            if ($request->stock_status === 'out_of_stock') {
                $query->whereDoesntHave('sizes', function ($subQuery) {
                    $subQuery->where('stock_quantity', '>', 0);
                });
            }
        }

        // Dynamic filter options and category counters
        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->withCount('products')
            ->get();

        $sleeveTypes = SleeveType::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $collectionTypes = CollectionType::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $categoryNameMap = Category::query()->pluck('name', 'id');

        // Get filter options
        $availableSizes = ProductSize::distinct()->pluck('size')->sort();
        $availableColors = ProductColor::distinct()->pluck('color_name')->sort();

        $products = $query->orderBy('created_at', 'desc')->paginate(12)->withQueryString();

        return view('admin.products.index', compact(
            'products', 
            'categories',
            'sleeveTypes',
            'collectionTypes',
            'categoryNameMap',
            'availableSizes', 
            'availableColors'
        ));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'fit_type' => 'nullable|in:regular,oversize,normal,slight_oversize',
            'sleeve_type_id' => 'nullable|exists:sleeve_types,id',
            'collection_type_id' => 'nullable|exists:collection_types,id',
            'product_weight_grams' => 'required|integer|min:1',
            'mrp' => 'required|numeric|min:0.01',
            'selling_price' => 'required|numeric|min:0.01|lte:mrp',
            'is_limited_edition' => 'boolean',
            'drop_month' => 'nullable|string',
            'drop_name' => 'nullable|string|max:255',
            'drop_story' => 'nullable|string',
            'drop_start_at' => 'nullable|date',
            'drop_end_at' => 'nullable|date|after_or_equal:drop_start_at',
            'quantity_limit' => 'nullable|integer|min:1',
            'countdown_enabled' => 'boolean',
            'auto_hide_out_of_stock' => 'boolean',
            'sizes' => 'required|array|min:1',
            'sizes.*' => 'in:xs,s,m,l,xl,xxl',
            'size_stocks' => 'nullable|array',
            'size_stocks.*' => 'nullable|integer|min:0',
            'colors' => 'required|array|min:1',
            'colors.*.name' => 'required|string|max:100',
            'colors.*.hex_code' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
            'colors.*.front_image' => 'nullable|image|max:5120',
            'colors.*.back_image' => 'nullable|image|max:5120',
            'colors.*.extra_images' => 'nullable|array',
            'colors.*.extra_images.*' => 'nullable|image|max:5120',
        ]);

        $isAccessoryCategory = $this->isAccessoryCategory((int) $validated['category_id']);

        if (! $isAccessoryCategory) {
            $request->validate([
                'fit_type' => 'required|in:regular,oversize,normal,slight_oversize',
                'sleeve_type_id' => 'required|exists:sleeve_types,id',
            ]);
        }

        $fitType = $isAccessoryCategory ? 'regular' : (string) $validated['fit_type'];
        $sleeveTypeId = $isAccessoryCategory ? null : ($validated['sleeve_type_id'] ?? null);
        $collectionTypeId = $isAccessoryCategory ? null : ($validated['collection_type_id'] ?? null);
        $mrp = (float) $validated['mrp'];
        $sellingPrice = (float) $validated['selling_price'];

        // Create product
        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
            'fit_type' => $fitType,
            'sleeve_type_id' => $sleeveTypeId,
            'collection_type_id' => $collectionTypeId,
            'product_weight_grams' => (int) $validated['product_weight_grams'],
            'mrp' => $mrp,
            'selling_price' => $sellingPrice,
            'base_price' => $sellingPrice,
            'is_limited_edition' => $validated['is_limited_edition'] ?? false,
            'drop_month' => $validated['drop_month'],
            'drop_name' => $validated['drop_name'] ?? null,
            'drop_story' => $validated['drop_story'] ?? null,
            'drop_start_at' => $validated['drop_start_at'] ?? null,
            'drop_end_at' => $validated['drop_end_at'] ?? null,
            'quantity_limit' => $validated['quantity_limit'] ?? null,
            'countdown_enabled' => $validated['countdown_enabled'] ?? false,
            'auto_hide_out_of_stock' => $validated['auto_hide_out_of_stock'] ?? false,
            'stock_limit' => ($validated['is_limited_edition'] ?? false) ? ($validated['quantity_limit'] ?? null) : null,
            'created_by' => auth()->guard('admin')->id(),
        ]);

        // Create sizes
        foreach ($validated['sizes'] as $size) {
            $stockQuantity = (int) ($validated['size_stocks'][$size] ?? 0);

            ProductSize::create([
                'product_id' => $product->id,
                'size' => $size,
                'stock_quantity' => $stockQuantity,
                'is_available' => $stockQuantity > 0,
            ]);
        }

        // Create colors with images
        if ($request->has('colors')) {
            $seenColorNames = [];
            foreach ($request->input('colors') as $index => $colorData) {
                $colorName = trim((string) ($colorData['name'] ?? ''));
                $normalizedColorName = strtolower($colorName);

                if ($colorName === '' || in_array($normalizedColorName, $seenColorNames, true)) {
                    continue;
                }

                $seenColorNames[] = $normalizedColorName;

                $color = ProductColor::create([
                    'product_id' => $product->id,
                    'color_name' => $colorName,
                    'hex_code' => $colorData['hex_code'] ?? null,
                    'is_active' => true,
                ]);

                // Upload front image
                if ($request->hasFile("colors.$index.front_image")) {
                    $frontPath = $request->file("colors.$index.front_image")
                        ->store("products/{$product->id}/colors/{$color->id}", 'public');
                    
                    ProductImage::create([
                        'product_color_id' => $color->id,
                        'image_type' => 'front',
                        'image_path' => $frontPath,
                    ]);
                }

                // Upload back image
                if ($request->hasFile("colors.$index.back_image")) {
                    $backPath = $request->file("colors.$index.back_image")
                        ->store("products/{$product->id}/colors/{$color->id}", 'public');
                    
                    ProductImage::create([
                        'product_color_id' => $color->id,
                        'image_type' => 'back',
                        'image_path' => $backPath,
                    ]);
                }

                if ($request->hasFile("colors.$index.extra_images")) {
                    foreach ($request->file("colors.$index.extra_images") as $extraImage) {
                        if (! $extraImage) {
                            continue;
                        }

                        $extraPath = $extraImage->store("products/{$product->id}/colors/{$color->id}", 'public');

                        ProductImage::create([
                            'product_color_id' => $color->id,
                            'image_type' => 'extra',
                            'image_path' => $extraPath,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('admin.products.show', $product)
            ->with('success', 'Product created successfully!');
    }

    public function show(Product $product)
    {
        $product->load('colors.images', 'sizes');
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $product->load('colors.images', 'sizes');
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'fit_type' => 'nullable|in:regular,oversize,normal,slight_oversize',
            'sleeve_type_id' => 'nullable|exists:sleeve_types,id',
            'collection_type_id' => 'nullable|exists:collection_types,id',
            'product_weight_grams' => 'required|integer|min:1',
            'mrp' => 'required|numeric|min:0.01',
            'selling_price' => 'required|numeric|min:0.01|lte:mrp',
            'is_limited_edition' => 'boolean',
            'drop_month' => 'nullable|string',
            'drop_name' => 'nullable|string|max:255',
            'drop_story' => 'nullable|string',
            'drop_start_at' => 'nullable|date',
            'drop_end_at' => 'nullable|date|after_or_equal:drop_start_at',
            'quantity_limit' => 'nullable|integer|min:1',
            'countdown_enabled' => 'boolean',
            'auto_hide_out_of_stock' => 'boolean',
            'size_stocks' => 'nullable|array',
            'size_stocks.*' => 'nullable|integer|min:0',
            'existing_colors' => 'nullable|array',
            'existing_colors.*.name' => 'required|string|max:100',
            'existing_colors.*.hex_code' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
            'existing_colors.*.front_image' => 'nullable|image|max:5120',
            'existing_colors.*.back_image' => 'nullable|image|max:5120',
            'existing_colors.*.extra_images' => 'nullable|array',
            'existing_colors.*.extra_images.*' => 'nullable|image|max:5120',
            'new_colors' => 'nullable|array',
            'new_colors.*.name' => 'nullable|string|max:100',
            'new_colors.*.hex_code' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
            'new_colors.*.front_image' => 'nullable|image|max:5120',
            'new_colors.*.back_image' => 'nullable|image|max:5120',
            'new_colors.*.extra_images' => 'nullable|array',
            'new_colors.*.extra_images.*' => 'nullable|image|max:5120',
        ]);

        $isAccessoryCategory = $this->isAccessoryCategory((int) $validated['category_id']);

        if (! $isAccessoryCategory) {
            $request->validate([
                'fit_type' => 'required|in:regular,oversize,normal,slight_oversize',
                'sleeve_type_id' => 'required|exists:sleeve_types,id',
            ]);
        }

        $fitType = $isAccessoryCategory ? 'regular' : (string) $validated['fit_type'];
        $sleeveTypeId = $isAccessoryCategory ? null : ($validated['sleeve_type_id'] ?? null);
        $collectionTypeId = $isAccessoryCategory ? null : ($validated['collection_type_id'] ?? null);
        $mrp = (float) $validated['mrp'];
        $sellingPrice = (float) $validated['selling_price'];

        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
            'fit_type' => $fitType,
            'sleeve_type_id' => $sleeveTypeId,
            'collection_type_id' => $collectionTypeId,
            'product_weight_grams' => (int) $validated['product_weight_grams'],
            'mrp' => $mrp,
            'selling_price' => $sellingPrice,
            'base_price' => $sellingPrice,
            'is_limited_edition' => $validated['is_limited_edition'] ?? false,
            'drop_month' => $validated['drop_month'],
            'drop_name' => $validated['drop_name'] ?? null,
            'drop_story' => $validated['drop_story'] ?? null,
            'drop_start_at' => $validated['drop_start_at'] ?? null,
            'drop_end_at' => $validated['drop_end_at'] ?? null,
            'quantity_limit' => $validated['quantity_limit'] ?? null,
            'countdown_enabled' => $validated['countdown_enabled'] ?? false,
            'auto_hide_out_of_stock' => $validated['auto_hide_out_of_stock'] ?? false,
            'stock_limit' => ($validated['is_limited_edition'] ?? false) ? ($validated['quantity_limit'] ?? null) : null,
        ]);

        if (!$product->is_limited_edition) {
            $product->update([
                'drop_name' => null,
                'drop_story' => null,
                'drop_start_at' => null,
                'drop_end_at' => null,
                'quantity_limit' => null,
                'countdown_enabled' => false,
                'auto_hide_out_of_stock' => false,
                'stock_limit' => null,
            ]);
        }

        if (!empty($validated['size_stocks'])) {
            foreach ($product->sizes as $size) {
                if (array_key_exists($size->size, $validated['size_stocks'])) {
                    $stockQuantity = (int) $validated['size_stocks'][$size->size];
                    $size->update([
                        'stock_quantity' => $stockQuantity,
                        'is_available' => $stockQuantity > 0,
                    ]);
                }
            }
        }

        $existingColors = $request->input('existing_colors', []);
        foreach ($existingColors as $colorId => $colorData) {
            $color = $product->colors()->whereKey($colorId)->first();

            if (!$color) {
                continue;
            }

            $color->update([
                'color_name' => $colorData['name'],
                'hex_code' => $colorData['hex_code'] ?? null,
            ]);

            if ($request->hasFile("existing_colors.$colorId.front_image")) {
                $this->replaceColorImage(
                    $product,
                    $color,
                    'front',
                    $request->file("existing_colors.$colorId.front_image")
                );
            }

            if ($request->hasFile("existing_colors.$colorId.back_image")) {
                $this->replaceColorImage(
                    $product,
                    $color,
                    'back',
                    $request->file("existing_colors.$colorId.back_image")
                );
            }

            if ($request->hasFile("existing_colors.$colorId.extra_images")) {
                foreach ($request->file("existing_colors.$colorId.extra_images") as $extraImage) {
                    if (! $extraImage) {
                        continue;
                    }

                    $extraPath = $extraImage->store("products/{$product->id}/colors/{$color->id}", 'public');

                    ProductImage::create([
                        'product_color_id' => $color->id,
                        'image_type' => 'extra',
                        'image_path' => $extraPath,
                    ]);
                }
            }
        }

        // Handle deletion of extra images marked in the edit form
        $deletedIds = array_filter((array) $request->input('delete_extra_images', []));
        if (!empty($deletedIds)) {
            $images = ProductImage::whereIn('id', $deletedIds)->get();
            foreach ($images as $img) {
                // Ensure the image belongs to this product
                if ($img->color && $img->color->product_id == $product->id) {
                    // Delete file from storage
                    Storage::disk('public')->delete($img->image_path);
                    // Delete DB record
                    $img->delete();
                }
            }
        }

        $existingNormalizedColorNames = $product->colors()
            ->pluck('color_name')
            ->map(fn ($name) => strtolower(trim((string) $name)))
            ->filter()
            ->values()
            ->all();

        foreach ($request->input('new_colors', []) as $index => $colorData) {
            $colorName = trim((string) ($colorData['name'] ?? ''));
            $normalizedColorName = strtolower($colorName);
            $hasFrontImage = $request->hasFile("new_colors.$index.front_image");
            $hasBackImage = $request->hasFile("new_colors.$index.back_image");
            $hasHexCode = !empty($colorData['hex_code']);

            if ($colorName === '' && !$hasFrontImage && !$hasBackImage && !$hasHexCode) {
                continue;
            }

            if ($colorName === '') {
                continue;
            }

            if (in_array($normalizedColorName, $existingNormalizedColorNames, true)) {
                continue;
            }

            $existingNormalizedColorNames[] = $normalizedColorName;

            $newColor = ProductColor::create([
                'product_id' => $product->id,
                'color_name' => $colorName,
                'hex_code' => $colorData['hex_code'] ?? null,
                'is_active' => true,
            ]);

            if ($hasFrontImage) {
                $this->replaceColorImage(
                    $product,
                    $newColor,
                    'front',
                    $request->file("new_colors.$index.front_image")
                );
            }

            if ($hasBackImage) {
                $this->replaceColorImage(
                    $product,
                    $newColor,
                    'back',
                    $request->file("new_colors.$index.back_image")
                );
            }

            if ($request->hasFile("new_colors.$index.extra_images")) {
                foreach ($request->file("new_colors.$index.extra_images") as $extraImage) {
                    if (! $extraImage) {
                        continue;
                    }

                    $extraPath = $extraImage->store("products/{$product->id}/colors/{$newColor->id}", 'public');

                    ProductImage::create([
                        'product_color_id' => $newColor->id,
                        'image_type' => 'extra',
                        'image_path' => $extraPath,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.show', $product)
            ->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        $product->colors()->each(function ($color) use ($product) {
            Storage::disk('public')->deleteDirectory("products/{$product->id}/colors/{$color->id}");
            $color->delete();
        });

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }

    public function addColor(Request $request, Product $product)
    {
        $validated = $request->validate([
            'color_name' => 'required|string|max:100',
            'hex_code' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
            'front_image' => 'required|image|max:5120',
            'back_image' => 'required|image|max:5120',
            'extra_images' => 'nullable|array',
            'extra_images.*' => 'nullable|image|max:5120',
        ]);

        $color = ProductColor::create([
            'product_id' => $product->id,
            'color_name' => $validated['color_name'],
            'hex_code' => $validated['hex_code'],
            'is_active' => true,
        ]);

        if ($request->hasFile('front_image')) {
            $frontPath = $request->file('front_image')
                ->store("products/{$product->id}/colors/{$color->id}", 'public');
            
            ProductImage::create([
                'product_color_id' => $color->id,
                'image_type' => 'front',
                'image_path' => $frontPath,
            ]);
        }

        if ($request->hasFile('back_image')) {
            $backPath = $request->file('back_image')
                ->store("products/{$product->id}/colors/{$color->id}", 'public');
            
            ProductImage::create([
                'product_color_id' => $color->id,
                'image_type' => 'back',
                'image_path' => $backPath,
            ]);
        }

        if ($request->hasFile('extra_images')) {
            foreach ($request->file('extra_images') as $extraImage) {
                if (! $extraImage) {
                    continue;
                }

                $extraPath = $extraImage->store("products/{$product->id}/colors/{$color->id}", 'public');

                ProductImage::create([
                    'product_color_id' => $color->id,
                    'image_type' => 'extra',
                    'image_path' => $extraPath,
                ]);
            }
        }

        return redirect()->route('admin.products.edit', $product)
            ->with('success', 'Color added successfully!');
    }

    public function deleteColor(ProductColor $color)
    {
        $product = $color->product;
        Storage::disk('public')->deleteDirectory("products/{$product->id}/colors/{$color->id}");
        $color->delete();

        return redirect()->route('admin.products.edit', $product)
            ->with('success', 'Color deleted successfully!');
    }

    protected function replaceColorImage(Product $product, ProductColor $color, string $imageType, UploadedFile $file): void
    {
        $path = $file->store("products/{$product->id}/colors/{$color->id}", 'public');

        $existingImage = $color->images()->where('image_type', $imageType)->first();

        if ($existingImage) {
            Storage::disk('public')->delete($existingImage->image_path);
            $existingImage->update(['image_path' => $path]);
            ImageOptimizer::warmVariants($path);

            return;
        }

        ProductImage::create([
            'product_color_id' => $color->id,
            'image_type' => $imageType,
            'image_path' => $path,
        ]);

        ImageOptimizer::warmVariants($path);
    }

    protected function isAccessoryCategory(int $categoryId): bool
    {
        $category = Category::query()->find($categoryId);

        if (! $category) {
            return false;
        }

        $name = strtolower((string) $category->name);
        $slug = strtolower((string) $category->slug);

        return str_contains($name, 'accessories') || str_contains($name, 'accessory')
            || str_contains($slug, 'accessories') || str_contains($slug, 'accessory');
    }
}
