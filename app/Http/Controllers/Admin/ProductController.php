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
    public function index()
    {
        $products = Product::with('colors', 'sizes')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.products.index', compact('products'));
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
            'category' => 'required|in:t-shirt,accessories',
            'fit_type' => 'required|in:normal,slight_oversize',
            'sleeve_type' => 'required|in:full,half',
            'base_price' => 'required|numeric|min:0.01',
            'is_limited_edition' => 'boolean',
            'drop_month' => 'nullable|string',
            'stock_limit' => 'nullable|integer|min:1',
            'sizes' => 'required|array|min:1',
            'sizes.*' => 'in:xs,s,m,l,xl,xxl',
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
            'stock_limit' => $validated['is_limited_edition'] ? $validated['stock_limit'] : null,
            'created_by' => auth()->guard('admin')->id(),
        ]);

        // Create sizes
        foreach ($validated['sizes'] as $size) {
            ProductSize::create([
                'product_id' => $product->id,
                'size' => $size,
                'stock_quantity' => 0,
                'is_available' => true,
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
            'fit_type' => 'required|in:normal,slight_oversize',
            'sleeve_type' => 'required|in:full,half',
            'base_price' => 'required|numeric|min:0.01',
            'is_limited_edition' => 'boolean',
            'drop_month' => 'nullable|string',
            'stock_limit' => 'nullable|integer|min:1',
        ]);

        $product->update($validated);

        if ($request->has('is_limited_edition')) {
            $product->update(['stock_limit' => $validated['stock_limit']]);
        } else {
            $product->update(['stock_limit' => null]);
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
