<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CollectionType;
use App\Models\DesignRequest;
use App\Models\HomeSetting;
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
        $homeSettingRecord = HomeSetting::first();
        $homeSettings = HomeSetting::mergedData($homeSettingRecord?->data);

        $bestSellerLimit = max(1, (int) ($homeSettings['best_seller']['product_limit'] ?? 8));
        $limitedEditionLimit = max(1, (int) ($homeSettings['limited_edition']['product_limit'] ?? 4));

        // Get featured products for the home page
        $featuredProducts = Product::where('is_active', true)
            ->with('images')
            ->get();

        $bestSellerProducts = Product::where('is_active', true)
            ->with('images')
            ->orderBy('created_at', 'desc')
            ->take($bestSellerLimit)
            ->get();

        $limitedEditionProducts = Product::where('is_active', true)
            ->where('is_limited_edition', true)
            ->with('images')
            ->orderBy('created_at', 'desc')
            ->take($limitedEditionLimit)
            ->get();

        $newArrivalProducts = Product::where('is_active', true)
            ->with('images')
            ->orderBy('created_at', 'desc')
            ->get();

        $hotCollectionProducts = Product::where('is_active', true)
            ->with('images')
            ->get();

        $testimonials = \App\Models\Testimonial::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $trendyProducts = Product::where('is_active', true)
            ->with('images')
            ->get();

        return view('frontend.home', compact(
            'homeSettings',
            'featuredProducts', 
            'bestSellerProducts', 
            'limitedEditionProducts',
            'newArrivalProducts',
            'hotCollectionProducts',
            'trendyProducts',
            'testimonials'
        ));
    }

    /**
     * Display the shop page
     */
    public function shop(Request $request, $category = null)
    {
        $query = Product::where('is_active', true)
            ->with(['images', 'colors', 'sizes', 'category', 'collectionType']);

        $stockFilter = $request->input('stock', 'all');
        $editionFilter = $request->input('edition', 'all');
        $storyFilter = $request->input('story', 'all');

        // Backward compatibility for old limited_edition query param
        if ($request->filled('limited_edition') && $request->limited_edition !== 'all' && $editionFilter === 'all') {
            $editionFilter = 'limited';
        }

        $selectedCategory = null;
        $selectedCollection = null;
        $isLimitedEdition = false;

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

        $categoryIds = array_values(array_filter((array) $request->input('category_id', [])));
        if (!empty($categoryIds)) {
            $query->whereIn('category_id', $categoryIds);
            $selectedCategory = Category::where('is_active', true)->find($categoryIds[0]);
        }

        // Filter by category slug if provided via URL segment
        if (empty($categoryIds) && ($category || $request->filled('category'))) {
            $categoryFilter = $category ?: $request->category;
            $normalizedCategory = Str::of($categoryFilter)->replace(['-', '_'], ' ')->lower()->value();

            $selectedCategory = Category::query()
                ->where('is_active', true)
                ->where(function ($categoryQuery) use ($categoryFilter, $normalizedCategory) {
                    $categoryQuery->where('slug', $categoryFilter)
                        ->orWhereRaw('LOWER(name) = ?', [$normalizedCategory]);
                })
                ->first();

            $query->where(function ($productQuery) use ($categoryFilter, $selectedCategory) {
                if ($selectedCategory) {
                    $productQuery->where('category_id', $selectedCategory->id)
                        ->orWhere('category', $categoryFilter);

                    return;
                }

                $productQuery->where('category', $categoryFilter);
            });
        }

        $collectionTypeIds = array_values(array_filter((array) $request->input('collection_type_id', [])));
        if (!empty($collectionTypeIds)) {
            $query->whereIn('collection_type_id', $collectionTypeIds);
            $selectedCollection = CollectionType::query()
                ->where('is_active', true)
                ->find($collectionTypeIds[0]);
        } elseif ($request->filled('collection_type_id')) {
            $selectedCollection = CollectionType::query()
                ->where('is_active', true)
                ->find($request->integer('collection_type_id'));

            if ($selectedCollection) {
                $query->where('collection_type_id', $selectedCollection->id);
            }
        }

        // Edition filter
        if ($editionFilter === 'limited') {
            $query->where('is_limited_edition', true);
            $isLimitedEdition = true;
        } elseif ($editionFilter === 'regular') {
            $query->where('is_limited_edition', false);
        }

        // Stock filter (in/out/all)
        if (($request->filled('in_stock') && $request->in_stock == '1') || $stockFilter === 'in') {
            $query->whereHas('sizes', function ($q) {
                $q->where('stock_quantity', '>', 0);
            });
        } elseif ($stockFilter === 'out') {
            $query->whereDoesntHave('sizes', function ($q) {
                $q->where('stock_quantity', '>', 0);
            });
        }

        // Size filter
        if ($request->filled('size')) {
            $sizes = array_map('strtolower', is_array($request->size) ? $request->size : [$request->size]);
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
        if ($request->filled('min_price')) {
            $query->where('base_price', '>=', (float) $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('base_price', '<=', (float) $request->max_price);
        }

        // Sleeve Type filter
        if ($request->filled('sleeve_type')) {
            $sleeveTypes = array_values(array_filter((array) $request->input('sleeve_type', [])));
            if (!empty($sleeveTypes)) {
                $query->whereIn('sleeve_type', $sleeveTypes);
            } elseif (is_string($request->sleeve_type)) {
                $query->where('sleeve_type', $request->sleeve_type);
            }
        }

        // Story filter
        if ($storyFilter === 'has') {
            $query->whereNotNull('drop_story')
                ->where('drop_story', '!=', '');
        } elseif ($storyFilter === 'none') {
            $query->where(function ($q) {
                $q->whereNull('drop_story')
                    ->orWhere('drop_story', '=','');
            });
        }

        // Sorting
        $sortBy = $request->get('sort', 'default');
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('base_price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('base_price', 'desc');
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
        $categoryOptions = Category::query()
            ->where('is_active', true)
            ->withCount([
                'products as active_products_count' => function ($query) {
                    $query->where('is_active', true);
                },
            ])
            ->orderBy('name')
            ->get();

        $collectionOptions = CollectionType::query()
            ->where('is_active', true)
            ->withCount([
                'products as active_products_count' => function ($query) use ($selectedCategory) {
                    $query->where('is_active', true);

                    if ($selectedCategory) {
                        $query->where('category_id', $selectedCategory->id);
                    }
                },
            ])
            ->orderBy('name')
            ->get();

        $limitedEditionCount = Product::query()
            ->where('is_active', true)
            ->where('is_limited_edition', true)
            ->count();

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
        $availableSleeveTypes = Product::query()
            ->where('is_active', true)
            ->when($selectedCategory, function ($query) use ($selectedCategory) {
                $query->where('category_id', $selectedCategory->id);
            })
            ->when($selectedCollection, function ($query) use ($selectedCollection) {
                $query->where('collection_type_id', $selectedCollection->id);
            })
            ->whereNotNull('sleeve_type')
            ->distinct()
            ->pluck('sleeve_type')
            ->toArray();
        
        // Get total count for display
        $totalProducts = Product::where('is_active', true)->count();
        
        // Get category stats for dynamic display
        $allActiveCategories = Product::where('is_active', true)
            ->distinct()
            ->pluck('category')
            ->filter(function($c) { return !is_null($c) && $c !== ''; })
            ->toArray();
        
        $categoryStats = [];
        $categoryStats['all'] = $totalProducts;
        foreach ($allActiveCategories as $cat) {
            $categoryStats[$cat] = Product::where('is_active', true)
                ->where('category', $cat)
                ->count();
        }
        $categoryStats['limited_edition'] = $limitedEditionCount;
        
        $products = $query->paginate(12)->appends($request->except('page'));

        $pageTitle = $isLimitedEdition
            ? 'Limited Edition'
            : ($selectedCollection?->name ?? $selectedCategory?->name ?? ($category ? ucwords(str_replace(['-', '_'], ' ', $category)) : 'Shop'));

        $maxPrice = (int) ceil(Product::where('is_active', true)->max('base_price') ?? 5000);
        $maxPrice = max($maxPrice, 500);

        return view('frontend.shop', compact(
            'products', 
            'category', 
            'pageTitle',
            'isLimitedEdition',
            'stockFilter',
            'editionFilter',
            'storyFilter',
            'selectedCategory',
            'selectedCollection',
            'categoryOptions',
            'collectionOptions',
            'limitedEditionCount',
            'availableSizes', 
            'availableColors',
            'availableSleeveTypes',
            'totalProducts',
            'categoryStats',
            'allActiveCategories',
            'maxPrice'
        ));
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
        $testimonials = \App\Models\Testimonial::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        return view('frontend.about', compact('testimonials'));
    }

    /**
     * Display contact page
     */
    public function contact()
    {
        // pull contact settings to make phone/address editable from admin
        $contactSettings = \App\Models\ContactSetting::first();
        return view('frontend.contact', compact('contactSettings'));
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
        $contactSettings = \App\Models\ContactSetting::first();
        return view('frontend.refund-policy', compact('contactSettings'));
    }
}