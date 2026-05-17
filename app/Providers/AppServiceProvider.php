<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\HomeSetting;
use App\Models\Product;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $offerPopup = HomeSetting::offerPopupData();
        $offerPopupImageUrl = trim((string) ($offerPopup['image_url'] ?? ''));

        View::share([
            'offerPopup' => $offerPopup,
            'showOfferPopup' => ! empty($offerPopup['enabled']) && $offerPopupImageUrl !== '',
            'offerPopupImageUrl' => $offerPopupImageUrl,
        ]);

        View::composer('frontend.partials.header', function ($view) {
            $categories = Category::query()
                ->where('is_active', true)
                ->with([
                    'products' => function ($query) {
                        $query->where('is_active', true)
                            ->whereNotNull('collection_type_id')
                            ->with(['collectionType:id,name,slug', 'images'])
                            ->orderBy('name');
                    },
                ])
                ->orderBy('name')
                ->get();

            $shopMenu = $categories->map(function ($category) {
                $categoryProducts = $category->products
                    ->filter(function ($product) {
                        return $product->collectionType !== null;
                    })
                    ->values();

                $collections = $categoryProducts
                    ->groupBy('collection_type_id')
                    ->map(function ($collectionProducts) {
                        $collection = $collectionProducts->first()->collectionType;

                        return [
                            'id' => $collection->id,
                            'name' => $collection->name,
                            'slug' => $collection->slug,
                            'product_count' => $collectionProducts->count(),
                            'products' => $collectionProducts
                                ->map(function ($product) {
                                    return [
                                        'id' => $product->id,
                                        'name' => $product->name,
                                        'image' => optional($product->images->first())->image_path,
                                    ];
                                })
                                ->values(),
                        ];
                    })
                    ->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
                    ->values();

                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'product_count' => $categoryProducts->count(),
                    'collections' => $collections,
                ];
            })->values();

            $view->with('shopMenu', $shopMenu);
            $view->with('promoBar', HomeSetting::promoBarData());
            $view->with('promoBarHtml', HomeSetting::promoBarHtml());
        });
    }
}
