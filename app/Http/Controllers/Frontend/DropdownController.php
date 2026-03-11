<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SleeveType;
use App\Models\CollectionType;
use Illuminate\Http\JsonResponse;

class DropdownController extends Controller
{
    /**
     * Get all active categories
     */
    public function getCategories(): JsonResponse
    {
        $categories = Category::where('is_active', true)
            ->select('id', 'name', 'slug', 'description')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    /**
     * Get all active sleeve types
     */
    public function getSleeveTypes(): JsonResponse
    {
        $sleeveTypes = SleeveType::where('is_active', true)
            ->select('id', 'name', 'slug', 'description')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $sleeveTypes
        ]);
    }

    /**
     * Get all active collection types
     */
    public function getCollectionTypes(): JsonResponse
    {
        $collectionTypes = CollectionType::where('is_active', true)
            ->select('id', 'name', 'slug', 'description')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $collectionTypes
        ]);
    }

    /**
     * Get all dropdown data at once
     */
    public function getAllDropdowns(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'categories' => Category::where('is_active', true)
                    ->select('id', 'name', 'slug', 'description')
                    ->orderBy('name')
                    ->get(),
                'sleeveTypes' => SleeveType::where('is_active', true)
                    ->select('id', 'name', 'slug', 'description')
                    ->orderBy('name')
                    ->get(),
                'collectionTypes' => CollectionType::where('is_active', true)
                    ->select('id', 'name', 'slug', 'description')
                    ->orderBy('name')
                    ->get(),
            ]
        ]);
    }
}
