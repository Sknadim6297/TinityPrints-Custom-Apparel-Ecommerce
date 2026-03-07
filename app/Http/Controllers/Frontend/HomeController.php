<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\DesignRequest;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page
     */
    public function index()
    {
        // Get featured products for the home page
        $featuredProducts = Product::where('is_active', true)
            ->with('images')
            ->get();

        $bestSellerProducts = Product::where('is_active', true)
            ->with('images')
            ->orderBy('created_at', 'desc')
            ->get();

        $newArrivalProducts = Product::where('is_active', true)
            ->with('images')
            ->orderBy('created_at', 'desc')
            ->get();

        $hotCollectionProducts = Product::where('is_active', true)
            ->with('images')
            ->get();

        $trendyProducts = Product::where('is_active', true)
            ->with('images')
            ->get();

        return view('frontend.home', compact(
            'featuredProducts', 
            'bestSellerProducts', 
            'newArrivalProducts',
            'hotCollectionProducts',
            'trendyProducts'
        ));
    }

    /**
     * Display the shop page
     */
    public function shop(Request $request, $category = null)
    {
        $query = Product::where('is_active', true)
            ->with(['images', 'colors', 'sizes']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('drop_story', 'LIKE', "%{$search}%")
                  ->orWhere('drop_name', 'LIKE', "%{$search}%");
            });
        }

        // Filter by category if provided
        if ($category || $request->filled('category')) {
            $categoryFilter = $category ?: $request->category;
            $query->where('category', $categoryFilter);
        }

        // Limited Edition filter
        if ($request->filled('limited_edition') && $request->limited_edition !== 'all') {
            $query->where('is_limited_edition', true);
        }

        // Size filter
        if ($request->filled('size')) {
            $sizes = is_array($request->size) ? $request->size : [$request->size];
            $query->whereHas('sizes', function($q) use ($sizes) {
                $q->whereIn('size', $sizes);
            });
        }

        // Color filter
        if ($request->filled('color')) {
            $colors = is_array($request->color) ? $request->color : [$request->color];
            $query->whereHas('colors', function($q) use ($colors) {
                $q->whereIn('color_name', $colors);
            });
        }

        // Price range filter
        if ($request->filled('min_price') || $request->filled('max_price')) {
            if ($request->filled('min_price')) {
                $query->where('price', '>=', $request->min_price);
            }
            if ($request->filled('max_price')) {
                $query->where('price', '<=', $request->max_price);
            }
        }

        // Sleeve Type filter
        if ($request->filled('sleeve_type')) {
            $query->where('sleeve_type', $request->sleeve_type);
        }

        // Sorting
        $sortBy = $request->get('sort', 'default');
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Get filter data for display
        $categoryStats = $this->getCategoryStats();
        $availableSizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
        $availableColors = Product::join('product_colors', 'products.id', '=', 'product_colors.product_id')
            ->where('products.is_active', true)
            ->distinct()
            ->select('product_colors.color_name', 'product_colors.hex_code')
            ->orderBy('product_colors.color_name')
            ->get()
            ->map(function($item) {
                return [
                    'name' => $item->color_name,
                    'hex' => $item->hex_code,
                ];
            })
            ->toArray();
        $availableSleeveTypes = Product::where('is_active', true)
            ->where('category', 't-shirt')
            ->whereNotNull('sleeve_type')
            ->distinct()
            ->pluck('sleeve_type')
            ->toArray();
        
        // Get total count for display
        $totalProducts = Product::where('is_active', true)->count();
        
        $products = $query->paginate(12)->appends($request->except('page'));

        return view('frontend.shop', compact(
            'products', 
            'category', 
            'categoryStats', 
            'availableSizes', 
            'availableColors',
            'availableSleeveTypes',
            'totalProducts'
        ));
    }

    /**
     * Get category statistics for filter sidebar
     */
    private function getCategoryStats()
    {
        return [
            't-shirt' => Product::where('category', 't-shirt')->where('is_active', true)->count(),
            'accessories' => Product::where('category', 'accessories')->where('is_active', true)->count(),
            'limited_edition' => Product::where('is_limited_edition', true)->where('is_active', true)->count(),
        ];
    }

    /**
     * Display product details
     */
    public function productDetails($id)
    {
        $product = Product::with(['colors.images', 'sizes'])->findOrFail($id);
        $relatedProducts = Product::with(['images', 'colors'])
            ->where('id', '!=', $id)
            ->where('is_active', true)
            ->orderByDesc('id')
            ->get()
            ->unique(function ($relatedProduct) {
                return strtolower(trim($relatedProduct->name));
            })
            ->take(4)
            ->values();

        return view('frontend.product-details', compact('product', 'relatedProducts'));
    }

    /**
     * Display about page
     */
    public function about()
    {
        return view('frontend.about');
    }

    /**
     * Display contact page
     */
    public function contact()
    {
        return view('frontend.contact');
    }

    /**
     * Handle contact form submission
     */
    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Handle contact form logic here
        // You can send email or store in database

        return back()->with('success', 'Thank you for your message. We will get back to you soon.');
    }

    /**
     * Display custom design page
     */
    public function customDesign()
    {
        $latestDesignRequest = DesignRequest::latest()->first();
        $productTypes = Product::whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category')
            ->mapWithKeys(function ($category) {
                $value = trim($category);
                $label = Str::title(str_replace(['-', '_'], ' ', $value));

                return [$value => $label];
            })
            ->toArray();

        if (empty($productTypes)) {
            $productTypes = [
                't-shirt' => 'T Shirt',
                'hoodie' => 'Hoodie',
                'bag' => 'Bag',
                'other' => 'Other',
            ];
        }

        return view('frontend.custom-design', compact('latestDesignRequest', 'productTypes'));
    }

    /**
     * Display limited edition page
     */
    public function limitedEdition()
    {
        // Get limited edition products
        $limitedProducts = Product::where('is_limited_edition', true)
            ->where('is_active', true)
            ->with(['images', 'colors', 'sizes'])
            ->paginate(12);

        return view('frontend.limited-edition', compact('limitedProducts'));
    }

    /**
     * Display refund policy page
     */
    public function refundPolicy()
    {
        return view('frontend.refund-policy');
    }
}