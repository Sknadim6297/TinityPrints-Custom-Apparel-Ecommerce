<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to view your wishlist.');
        }

        $wishlistItems = Wishlist::where('user_id', auth()->id())
            ->with(['product.images', 'product.colors'])
            ->get();

        return view('frontend.wishlist', compact('wishlistItems'));
    }

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Please login to add items to wishlist.'], 401);
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $exists = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $validated['product_id'])
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Product already in wishlist.']);
        }

        Wishlist::create([
            'user_id' => auth()->id(),
            'product_id' => $validated['product_id'],
        ]);

        $wishlistCount = Wishlist::where('user_id', auth()->id())->count();
        $wishlistItems = $this->getWishlistItemsData();

        return response()->json([
            'success' => true,
            'message' => 'Product added to wishlist!',
            'wishlist_count' => $wishlistCount,
            'wishlist_items' => $wishlistItems
        ]);
    }

    public function getSidebarItems()
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Please login.'], 401);
        }

        $sidebarWishlistItems = Wishlist::where('user_id', auth()->id())
            ->with(['product.images'])
            ->latest()
            ->take(3)
            ->get();

        $html = view('frontend.partials.sidebar-wishlist-items', [
            'sidebarWishlistItems' => $sidebarWishlistItems
        ])->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'wishlist_count' => Wishlist::where('user_id', auth()->id())->count()
        ]);
    }

    private function getWishlistItemsData()
    {
        $wishlistItems = Wishlist::where('user_id', auth()->id())
            ->with(['product.images'])
            ->get();

        return $wishlistItems->map(function ($item) {
            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'price' => $item->product->price,
                'image' => $item->product->images->first() ? \Illuminate\Support\Facades\Storage::url($item->product->images->first()->image_path) : null,
            ];
        });
    }

    public function destroy($id)
    {
        Wishlist::where('id', $id)
            ->where('user_id', auth()->id())
            ->delete();

        return redirect()->back()->with('success', 'Item removed from wishlist.');
    }
}
