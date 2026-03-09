<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\ProductSize;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to view your cart.');
        }

        $cartItems = Cart::where('user_id', auth()->id())
            ->with(['product.images', 'color'])
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('frontend.cart', compact('cartItems', 'subtotal'));
    }

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Please login to add items to cart.'], 401);
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'color_id' => 'nullable|exists:product_colors,id',
            'size' => 'nullable|string|in:xs,s,m,l,xl,xxl',
        ]);

        $product = Product::with(['sizes', 'colors'])->findOrFail($validated['product_id']);

        if ($validated['color_id'] ?? null) {
            $validColor = $product->colors->contains('id', (int) $validated['color_id']);
            if (!$validColor) {
                return response()->json([
                    'success' => false,
                    'message' => 'Selected color is not valid for this product.',
                ], 422);
            }
        }

        $sizeInventoryEnabled = $product->sizes->isNotEmpty();
        $selectedSize = isset($validated['size']) ? strtolower((string) $validated['size']) : null;

        if ($sizeInventoryEnabled && !$selectedSize) {
            return response()->json([
                'success' => false,
                'message' => 'Please select a size before adding this product to cart.',
            ], 422);
        }

        if ($selectedSize) {
            $validated['size'] = $selectedSize;
        }

        $cart = Cart::where('user_id', auth()->id())
            ->where('product_id', $validated['product_id'])
            ->where('product_color_id', $validated['color_id'] ?? null)
            ->where('size', $validated['size'] ?? null)
            ->first();

        if ($cart) {
            $newQuantity = $cart->quantity + $validated['quantity'];

            if ($sizeInventoryEnabled) {
                $sizeRow = ProductSize::where('product_id', $product->id)
                    ->where('size', $selectedSize)
                    ->first();

                if (!$sizeRow) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Selected size is not available for this product.',
                    ], 422);
                }

                if ($newQuantity > (int) $sizeRow->stock_quantity) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Only ' . $sizeRow->stock_quantity . ' item(s) available for size ' . strtoupper($selectedSize) . '.',
                    ], 422);
                }
            }

            $cart->quantity = $newQuantity;
            $cart->save();
        } else {
            if ($sizeInventoryEnabled) {
                $sizeRow = ProductSize::where('product_id', $product->id)
                    ->where('size', $selectedSize)
                    ->first();

                if (!$sizeRow) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Selected size is not available for this product.',
                    ], 422);
                }

                if ($validated['quantity'] > (int) $sizeRow->stock_quantity) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Only ' . $sizeRow->stock_quantity . ' item(s) available for size ' . strtoupper($selectedSize) . '.',
                    ], 422);
                }
            }

            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $validated['product_id'],
                'product_color_id' => $validated['color_id'] ?? null,
                'size' => $validated['size'] ?? null,
                'quantity' => $validated['quantity'],
            ]);
        }

        $cartCount = Cart::where('user_id', auth()->id())->count();
        $cartItems = $this->getCartItemsData();

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart!',
            'cart_count' => $cartCount,
            'cart_items' => $cartItems['items'],
            'cart_total' => $cartItems['total']
        ]);
    }

    public function getSidebarItems()
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Please login.'], 401);
        }

        $sidebarCartItems = Cart::where('user_id', auth()->id())
            ->with(['product.images', 'color'])
            ->latest()
            ->take(3)
            ->get();

        $sidebarCartTotal = $sidebarCartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        $html = view('frontend.partials.sidebar-cart-items', [
            'sidebarCartItems' => $sidebarCartItems,
            'sidebarCartTotal' => $sidebarCartTotal
        ])->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'cart_count' => Cart::where('user_id', auth()->id())->count(),
            'cart_total' => $sidebarCartTotal
        ]);
    }

    private function getCartItemsData()
    {
        $cartItems = Cart::where('user_id', auth()->id())
            ->with(['product.images', 'color'])
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $items = $cartItems->map(function ($item) {
            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'color' => $item->color ? $item->color->color_name : null,
                'size' => $item->size,
                'image' => $item->product->images->first() ? \Illuminate\Support\Facades\Storage::url($item->product->images->first()->image_path) : null,
                'subtotal' => $item->product->price * $item->quantity
            ];
        });

        return [
            'items' => $items,
            'total' => $total
        ];
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $selectedSize = $cart->size ? strtolower((string) $cart->size) : null;
        if ($selectedSize) {
            $sizeRow = ProductSize::where('product_id', $cart->product_id)
                ->where('size', $selectedSize)
                ->first();

            if (!$sizeRow) {
                return response()->json([
                    'success' => false,
                    'message' => 'Selected size is no longer available.',
                ], 422);
            }

            if ($validated['quantity'] > (int) $sizeRow->stock_quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only ' . $sizeRow->stock_quantity . ' item(s) available for size ' . strtoupper($selectedSize) . '.',
                ], 422);
            }
        }

        $cart->quantity = $validated['quantity'];
        $cart->save();

        // Get updated cart totals
        $cartItems = Cart::where('user_id', auth()->id())
            ->with(['product.images', 'color'])
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $itemTotal = $cart->product->price * $cart->quantity;

        return response()->json([
            'success' => true, 
            'message' => 'Cart updated successfully.',
            'itemTotal' => $itemTotal,
            'subtotal' => $subtotal
        ]);
    }

    public function destroy($id)
    {
        Cart::where('id', $id)
            ->where('user_id', auth()->id())
            ->delete();

        return redirect()->back()->with('success', 'Item removed from cart.');
    }

    public function applyCoupon(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Please login to apply coupons.'], 401);
        }

        $validated = $request->validate([
            'coupon_code' => 'required|string|max:50',
        ]);

        $couponCode = strtoupper($validated['coupon_code']);
        
        // Find the coupon
        $coupon = Coupon::where('code', $couponCode)
            ->where('is_active', true)
            ->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or inactive coupon code.'
            ], 422);
        }

        // Check if coupon has expired
        if ($coupon->expires_at && $coupon->expires_at->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'This coupon has expired.'
            ], 422);
        }

        // Check if coupon has reached its total usage limit (across all customers)
        if ($coupon->hasReachedTotalUsageLimit()) {
            return response()->json([
                'success' => false,
                'message' => 'This coupon has reached its maximum usage limit.'
            ], 422);
        }

        // Check if user has reached the per-customer usage limit for this coupon
        if ($coupon->hasReachedUsageLimit(auth()->id())) {
            $limit = $coupon->per_customer_usage_limit;
            return response()->json([
                'success' => false,
                'message' => "You have already used this coupon {$limit} time(s). Your usage limit reached."
            ], 422);
        }

        // Check customer email if specified
        if ($coupon->customer_email && $coupon->customer_email !== auth()->user()->email) {
            return response()->json([
                'success' => false,
                'message' => 'This coupon is not valid for your email address.'
            ], 422);
        }

        // Calculate subtotal
        $cartItems = Cart::where('user_id', auth()->id())
            ->with(['product'])
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // Check minimum order value
        if ($coupon->min_order_value && $subtotal < $coupon->min_order_value) {
            return response()->json([
                'success' => false,
                'message' => 'Minimum order value of ₹' . number_format($coupon->min_order_value, 2) . ' required.'
            ], 422);
        }

        // Calculate discount
        $discount = 0;
        if ($coupon->discount_type === 'flat') {
            $discount = $coupon->discount_value;
        } else if ($coupon->discount_type === 'percentage') {
            $discount = ($subtotal * $coupon->discount_value) / 100;
        }

        // Cap discount to not exceed subtotal
        $discount = min($discount, $subtotal);

        $total = max(0, $subtotal - $discount);

        // Store coupon in session (for both cart and checkout)
        // Note: The coupon will be marked as used only when the order is successfully placed
        session([
            'applied_coupon' => [
                'code' => $coupon->code,
                'discount' => $discount,
                'discount_type' => $coupon->discount_type,
                'discount_value' => $coupon->discount_value
            ],
            'coupon_code' => $coupon->code,
            'coupon_discount' => $discount
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully!',
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total,
            'coupon_code' => $coupon->code
        ]);
    }

    public function getAvailableCoupons()
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to view available coupons.'
            ], 401);
        }

        // Get current cart subtotal
        $cartItems = Cart::where('user_id', auth()->id())
            ->with(['product'])
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // Get already applied coupon
        $appliedCoupon = session('applied_coupon');
        $appliedCode = $appliedCoupon ? $appliedCoupon['code'] : null;

        // Fetch all active coupons (including those not meeting min requirements)
        $allCoupons = Coupon::where('is_active', true)
            ->where(function ($query) {
                // Coupon not expired
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', now());
            })
            ->where(function ($query) {
                // Check customer email restriction - coupon is valid for all or specific email
                $query->whereNull('customer_email')
                    ->orWhere('customer_email', auth()->user()->email);
            })
            ->get()
            ->map(function ($coupon) use ($subtotal, $appliedCode) {
                $isApplied = $appliedCode && $coupon->code === $appliedCode;
                $meetsMinimum = !$coupon->min_order_value || $subtotal >= $coupon->min_order_value;
                $hasReachedLimit = $coupon->hasReachedUsageLimit(auth()->id());
                $isAvailable = !$isApplied && $meetsMinimum && !$hasReachedLimit;
                
                return [
                    'code' => $coupon->code,
                    'discount_type' => $coupon->discount_type,
                    'discount_value' => $coupon->discount_value,
                    'min_order_value' => $coupon->min_order_value,
                    'expires_at' => $coupon->expires_at,
                    'is_available' => $isAvailable,
                    'is_applied' => $isApplied,
                    'meets_minimum' => $meetsMinimum,
                    'has_reached_limit' => $hasReachedLimit,
                    'usage_limit' => $coupon->usage_limit,
                    'user_usage_count' => $coupon->getUserUsageCount(auth()->id()),
                    'required_amount' => $coupon->min_order_value ? max(0, $coupon->min_order_value - $subtotal) : 0
                ];
            })
            ->sortByDesc(function ($coupon) {
                // Sort by availability first, then discount amount
                return [$coupon['is_available'], (float)$coupon['discount_value']];
            })
            ->values();

        // Separate available and unavailable coupons
        $availableCoupons = $allCoupons->where('is_available', true)->values();
        $unavailableCoupons = $allCoupons->where('is_available', false)->values();

        return response()->json([
            'success' => true,
            'coupons' => $availableCoupons,
            'unavailable_coupons' => $unavailableCoupons,
            'current_subtotal' => $subtotal
        ]);
    }

    public function removeCoupon()
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to remove coupon.'
            ], 401);
        }

        // Get current cart subtotal
        $cartItems = Cart::where('user_id', auth()->id())
            ->with(['product'])
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // Remove coupon from session
        session()->forget(['applied_coupon', 'coupon_code', 'coupon_discount']);

        return response()->json([
            'success' => true,
            'message' => 'Coupon removed successfully!',
            'subtotal' => $subtotal,
            'total' => $subtotal
        ]);
    }
}
