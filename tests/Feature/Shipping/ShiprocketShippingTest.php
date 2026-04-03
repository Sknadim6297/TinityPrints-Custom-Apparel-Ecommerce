<?php

use App\Models\Admin;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Services\Shipping\ShiprocketService;

beforeEach(function () {
    config()->set('shipping.shiprocket.mode', 'mock');
    $this->withoutMiddleware(\App\Http\Middleware\ValidateCsrfToken::class);
});

function makeShippingOrder(User $user, array $overrides = []): Order
{
    return Order::create(array_merge([
        'user_id' => $user->id,
        'order_number' => 'ORD-' . strtoupper(uniqid()),
        'customer_name' => 'Test Customer',
        'phone' => '+91 9000000000',
        'email' => 'customer@example.com',
        'product_name' => 'Demo T-Shirt',
        'product_size' => 'm',
        'quantity' => 1,
        'subtotal' => 999.00,
        'discount_amount' => 0.00,
        'total_amount' => 999.00,
        'payment_method' => 'online',
        'payment_status' => 'paid',
        'order_status' => 'paid',
        'custom_design_status' => 'not_required',
        'shipping_address' => 'Demo Street 1',
        'shipping_city' => 'Mumbai',
        'shipping_state' => 'MH',
        'shipping_postal_code' => '400001',
        'shipping_country' => 'India',
        'shipping_partner' => null,
        'shipping_weight_grams' => null,
        'shipping_cost' => null,
        'shipping_method' => null,
        'tracking_number' => null,
        'delivery_status' => 'pending',
        'placed_at' => now(),
        'paid_at' => now(),
    ], $overrides));
}

it('calculates shipping cost after the first 100 grams only', function () {
    $service = app(ShiprocketService::class);

    expect($service->calculateShippingCost(90))->toBe(0.0)
        ->and($service->calculateShippingCost(100))->toBe(0.0)
        ->and($service->calculateShippingCost(150))->toBe(1000.0);
});

it('creates a mock shipment and updates the order record', function () {
    $admin = Admin::create([
        'name' => 'Order Manager',
        'email' => 'manager@example.com',
        'password' => 'password',
        'role' => 'order_manager',
        'is_active' => true,
    ]);

    $user = User::factory()->create();
    $order = makeShippingOrder($user, [
        'shipping_weight_grams' => 150,
    ]);

    $this->actingAs($admin, 'admin')
        ->post(route('admin.orders.shipment.create', $order))
        ->assertRedirect(route('admin.orders.show', $order));

    $order->refresh();

    expect($order->shipping_partner)->toBe('Shiprocket')
        ->and($order->shipping_method)->toBe('Shiprocket Standard')
        ->and($order->delivery_status)->toBe('shipped')
        ->and($order->order_status)->toBe('shipped')
        ->and($order->shipping_cost)->toBe('1000.00')
        ->and($order->tracking_number)->not()->toBeNull();
});

it('syncs a shipped order and preserves the delivered status in mock mode', function () {
    $admin = Admin::create([
        'name' => 'Order Manager',
        'email' => 'manager-sync@example.com',
        'password' => 'password',
        'role' => 'order_manager',
        'is_active' => true,
    ]);

    $user = User::factory()->create();
    $order = makeShippingOrder($user, [
        'order_status' => 'delivered',
        'delivery_status' => 'delivered',
        'shipping_weight_grams' => 220,
        'shipping_partner' => 'Shiprocket',
        'shipping_method' => 'Shiprocket Express',
        'tracking_number' => 'SR-MOCK-001',
        'shipping_cost' => 2400.0,
        'delivered_at' => now()->subDay(),
        'delivered_date' => now()->subDay(),
    ]);

    $this->actingAs($admin, 'admin')
        ->post(route('admin.orders.shipment.sync', $order))
        ->assertRedirect(route('admin.orders.show', $order));

    $order->refresh();

    expect($order->delivery_status)->toBe('delivered')
        ->and($order->order_status)->toBe('delivered')
        ->and($order->tracking_number)->toBe('SR-MOCK-001')
        ->and($order->delivered_at)->not()->toBeNull();
});

it('recalculates shipping cost when an admin updates the order weight', function () {
    $admin = Admin::create([
        'name' => 'Order Manager',
        'email' => 'manager-update@example.com',
        'password' => 'password',
        'role' => 'order_manager',
        'is_active' => true,
    ]);

    $user = User::factory()->create();
    $order = makeShippingOrder($user);

    $this->actingAs($admin, 'admin')
        ->patch(route('admin.orders.update', $order), [
            'order_status' => 'paid',
            'payment_status' => 'paid',
            'delivery_status' => 'pending',
            'tracking_number' => 'SR-MOCK-UPDATE',
            'shipping_method' => 'Shiprocket Standard',
            'shipping_partner' => 'Shiprocket',
            'shipping_weight_grams' => 175,
        ])
        ->assertRedirect(route('admin.orders.index'));

    $order->refresh();

    expect($order->shipping_cost)->toBe('1500.00')
        ->and($order->shipping_weight_grams)->toBe(175)
        ->and($order->shipping_partner)->toBe('Shiprocket')
        ->and($order->shipping_method)->toBe('Shiprocket Standard');
});

it('derives shipment weight from product weights', function () {
    $service = app(ShiprocketService::class);

    $user = User::factory()->create();
    $product = Product::create([
        'name' => 'Weighted Demo Product',
        'description' => null,
        'category' => 't-shirt',
        'fit_type' => 'regular',
        'sleeve_type' => 'full',
        'base_price' => 499.00,
        'mrp' => 499.00,
        'selling_price' => 499.00,
        'product_weight_grams' => 300,
        'is_limited_edition' => false,
        'drop_month' => null,
        'stock_limit' => null,
        'is_active' => true,
        'created_by' => null,
    ]);

    $order = makeShippingOrder($user);

    OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $product->id,
        'product_name' => $product->name,
        'product_color_id' => null,
        'color_name' => null,
        'size' => 'm',
        'price' => 499.00,
        'quantity' => 2,
        'total' => 998.00,
        'stock_deducted' => false,
        'stock_restored' => false,
    ]);

    $calculatedWeight = $service->calculateOrderWeight($order);

    expect($calculatedWeight)->toBe(600);

    $service->createShipment($order);

    $order->refresh();

    expect($order->shipping_weight_grams)->toBe(600)
        ->and($order->tracking_number)->not()->toBeNull();
});