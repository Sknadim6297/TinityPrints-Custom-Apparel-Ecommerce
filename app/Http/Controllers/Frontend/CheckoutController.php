<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\UserAddress;
use App\Support\AdminNotifier;
use App\Support\InventoryManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to checkout.');
        }

        $cartItems = Cart::where('user_id', auth()->id())
            ->with(['product.images', 'color'])
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // Get discount from session if coupon is applied
        $discountAmount = session('coupon_discount', 0);
        $couponCode = session('coupon_code', null);

        // Cap discount to not exceed subtotal
        $discountAmount = min($discountAmount, $subtotal);

        $total = max(0, $subtotal - $discountAmount);

        // Get user's saved addresses
        $savedAddresses = UserAddress::where('user_id', auth()->id())
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get default address
        $defaultAddress = $savedAddresses->where('is_default', true)->first();

        return view('frontend.checkout', compact('cartItems', 'subtotal', 'discountAmount', 'total', 'couponCode', 'savedAddresses', 'defaultAddress'));
    }

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to place an order.');
        }

        $validated = $request->validate([
            'address_id' => 'nullable|exists:user_addresses,id',
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'shipping_address' => 'required|string|max:500',
            'landmark' => 'nullable|string|max:255',
            'shipping_city' => 'required|string|max:100',
            'shipping_state' => 'nullable|string|max:100',
            'shipping_postal_code' => 'nullable|string|max:20',
            'shipping_country' => 'required|string|max:100',
            'payment_method' => 'required|in:cod,online,bank_transfer',
            'save_address' => 'nullable|boolean',
            'address_label' => 'nullable|string|max:50',
            'set_default' => 'nullable|boolean',
        ]);

        $cartItems = Cart::where('user_id', auth()->id())
            ->with(['product', 'color'])
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $discountAmount = session('coupon_discount', 0);
        $couponCode = session('coupon_code', null);

        // Cap discount to not exceed subtotal
        $discountAmount = min($discountAmount, $subtotal);
        $total = max(0, $subtotal - $discountAmount);

        DB::beginTransaction();

        try {
            // Save address if requested
            if ($request->save_address) {
                $addressData = [
                    'user_id' => auth()->id(),
                    'label' => $validated['address_label'] ?? 'Other',
                    'full_name' => $validated['customer_name'],
                    'phone' => $validated['phone'],
                    'address' => $validated['shipping_address'],
                    'landmark' => $validated['landmark'] ?? null,
                    'city' => $validated['shipping_city'],
                    'state' => $validated['shipping_state'] ?? null,
                    'postal_code' => $validated['shipping_postal_code'] ?? null,
                    'country' => $validated['shipping_country'],
                    'is_default' => $request->set_default ? true : false,
                ];

                $newAddress = UserAddress::create($addressData);

                if ($request->set_default) {
                    $newAddress->setAsDefault();
                }
            }

            // Combine address with landmark for order
            $fullAddress = $validated['shipping_address'];
            if (!empty($validated['landmark'])) {
                $fullAddress .= ', Landmark: ' . $validated['landmark'];
            }

            // Generate unique order number
            $orderNumber = 'ORD-' . strtoupper(uniqid());

            // Reserve stock only for the selected sizes in cart.
            InventoryManager::decrementForCartItems($cartItems);

            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => $orderNumber,
                'customer_name' => $validated['customer_name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'shipping_address' => $fullAddress,
                'shipping_city' => $validated['shipping_city'],
                'shipping_state' => $validated['shipping_state'] ?? null,
                'shipping_postal_code' => $validated['shipping_postal_code'] ?? null,
                'shipping_country' => $validated['shipping_country'],
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'total_amount' => $total,
                'payment_method' => $validated['payment_method'],
                'payment_status' => $validated['payment_method'] === 'cod' ? 'pending' : 'pending',
                'order_status' => 'payment_pending',
                'coupon_code' => $couponCode,
                'product_name' => 'Multiple Items', // For compatibility
                'product_size' => 'Various', // For compatibility
                'quantity' => $cartItems->sum('quantity'),
                'custom_design_status' => 'not_required',
                'placed_at' => now(),
            ]);

            // Create order items
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_name' => $cartItem->product->name,
                    'product_color_id' => $cartItem->product_color_id,
                    'color_name' => $cartItem->color ? $cartItem->color->color_name : null,
                    'size' => $cartItem->size,
                    'price' => $cartItem->product->price,
                    'quantity' => $cartItem->quantity,
                    'total' => $cartItem->product->price * $cartItem->quantity,
                    'stock_deducted' => !empty($cartItem->size),
                    'stock_restored' => false,
                ]);
            }

            // Clear cart
            Cart::where('user_id', auth()->id())->delete();

            // Clear coupon session
            session()->forget(['coupon_code', 'coupon_discount']);

            // Notify admins
            AdminNotifier::notifyAll(
                'New Order Received',
                'Order ' . $orderNumber . ' has been placed by ' . $validated['customer_name'] . '. Total: ₹' . number_format($total, 2),
                'success',
                route('admin.orders.index'),
                'View Orders',
                ['order_id' => $order->id, 'order_number' => $orderNumber]
            );

            DB::commit();

            return redirect()->route('order.success', ['order' => $order->id])
                ->with('success', 'Order placed successfully! Order Number: ' . $orderNumber);

        } catch (ValidationException $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->withErrors($e->errors())
                ->with('error', 'Some items are out of stock for the selected size. Please update your cart and try again.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to place order. Please try again. Error: ' . $e->getMessage());
        }
    }

    public function success($orderId)
    {
        $order = Order::with('items.product.images')
            ->where('id', $orderId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('frontend.order-success', compact('order'));
    }
}
