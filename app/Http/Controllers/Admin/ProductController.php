<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['colors.images', 'sizes', 'admin']);

        // Apply filters
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('sleeve_type')) {
            $query->where('sleeve_type', $request->sleeve_type);
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

        // Get segment counts
        $tshirtCount = Product::where('category', 't-shirt')->count();
        $accessoriesCount = Product::where('category', 'accessories')->count();

        // Get filter options
        $availableSizes = ProductSize::distinct()->pluck('size')->sort();
        $availableColors = ProductColor::distinct()->pluck('color_name')->sort();

        $products = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('admin.products.index', compact(
            'products', 
            'tshirtCount', 
            'accessoriesCount', 
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
            'category' => 'nullable|in:t-shirt,accessories',
            'fit_type' => 'required|in:regular,oversize',
            'sleeve_type' => 'nullable|in:full,half',
            'base_price' => 'required|numeric|min:0.01',
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
        ]);

        // Create product
        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'fit_type' => $validated['fit_type'],
            'sleeve_type' => $validated['sleeve_type'],
            'base_price' => $validated['base_price'],
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
            foreach ($request->input('colors') as $index => $colorData) {
                $color = ProductColor::create([
                    'product_id' => $product->id,
                    'color_name' => $colorData['name'],
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
            }
        }

        if ($product->auto_hide_out_of_stock && $product->totalStock() === 0) {
            $product->update(['is_active' => false]);
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
            'category' => 'required|in:t-shirt,accessories',
            'fit_type' => 'required|in:regular,oversize',
            'sleeve_type' => 'required|in:full,half',
            'base_price' => 'required|numeric|min:0.01',
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
        ]);

        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'category' => $validated['category'] ?? $product->category,
            'fit_type' => $validated['fit_type'],
            'sleeve_type' => $validated['sleeve_type'] ?? $product->sleeve_type,
            'base_price' => $validated['base_price'],
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

        if ($product->auto_hide_out_of_stock && $product->totalStock() === 0) {
            $product->update(['is_active' => false]);
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
}
