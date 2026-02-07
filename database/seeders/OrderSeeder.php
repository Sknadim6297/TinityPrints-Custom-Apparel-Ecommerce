<?php

namespace Database\Seeders;

use App\Models\DesignRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product = Product::first();
        $designRequest = DesignRequest::first();

        Order::updateOrCreate([
            'order_number' => 'ORD-2026-1001',
        ], [
            'customer_name' => 'Ayesha Khan',
            'phone' => '+92 300 1234567',
            'email' => 'ayesha.khan@example.com',
            'product_id' => $product?->id,
            'product_name' => $product?->name ?? 'Classic White T-Shirt',
            'product_size' => 'm',
            'quantity' => 2,
            'design_request_id' => $designRequest?->id,
            'custom_design_status' => 'pending',
            'payment_status' => 'pending',
            'order_status' => 'design_pending',
            'shipping_address' => 'House 12, Street 8, F-10',
            'shipping_city' => 'Islamabad',
            'shipping_state' => 'ICT',
            'shipping_postal_code' => '44000',
            'shipping_country' => 'Pakistan',
            'shipping_partner' => 'Leopard',
            'shipping_weight_grams' => 250,
            'shipping_cost' => 3000,
            'shipping_method' => 'Leopard Courier',
            'tracking_number' => null,
            'delivery_status' => 'pending',
        ]);

        Order::updateOrCreate([
            'order_number' => 'ORD-2026-1002',
        ], [
            'customer_name' => 'John Carter',
            'phone' => '+1 415 555 1199',
            'email' => 'john.carter@example.com',
            'product_id' => $product?->id,
            'product_name' => $product?->name ?? 'Classic White T-Shirt',
            'product_size' => 'l',
            'quantity' => 1,
            'design_request_id' => null,
            'custom_design_status' => 'not_required',
            'payment_status' => 'paid',
            'order_status' => 'printing',
            'shipping_address' => '221B Baker Street',
            'shipping_city' => 'London',
            'shipping_state' => null,
            'shipping_postal_code' => 'NW1',
            'shipping_country' => 'United Kingdom',
            'shipping_partner' => 'DHL',
            'shipping_weight_grams' => 180,
            'shipping_cost' => 1600,
            'shipping_method' => 'DHL',
            'tracking_number' => 'DHL123456789',
            'delivery_status' => 'in_transit',
        ]);

        Order::updateOrCreate([
            'order_number' => 'ORD-2026-1003',
        ], [
            'customer_name' => 'Sara Iqbal',
            'phone' => '+92 333 8889900',
            'email' => 'sara.iqbal@example.com',
            'product_id' => $product?->id,
            'product_name' => $product?->name ?? 'Classic White T-Shirt',
            'product_size' => 's',
            'quantity' => 3,
            'design_request_id' => $designRequest?->id,
            'custom_design_status' => 'changes_requested',
            'payment_status' => 'pending',
            'order_status' => 'payment_pending',
            'shipping_address' => 'Block 5, Gulshan',
            'shipping_city' => 'Karachi',
            'shipping_state' => 'Sindh',
            'shipping_postal_code' => '75290',
            'shipping_country' => 'Pakistan',
            'shipping_partner' => 'TCS',
            'shipping_weight_grams' => 120,
            'shipping_cost' => 400,
            'shipping_method' => 'TCS',
            'tracking_number' => null,
            'delivery_status' => 'pending',
        ]);

        Order::updateOrCreate([
            'order_number' => 'ORD-2026-1004',
        ], [
            'customer_name' => 'Omar Sheikh',
            'phone' => '+92 321 4567890',
            'email' => 'omar.sheikh@example.com',
            'product_id' => $product?->id,
            'product_name' => $product?->name ?? 'Classic White T-Shirt',
            'product_size' => 'xl',
            'quantity' => 1,
            'design_request_id' => null,
            'custom_design_status' => 'not_required',
            'payment_status' => 'refunded',
            'order_status' => 'refunded',
            'shipping_address' => 'Street 9, DHA Phase 2',
            'shipping_city' => 'Lahore',
            'shipping_state' => 'Punjab',
            'shipping_postal_code' => '54000',
            'shipping_country' => 'Pakistan',
            'shipping_partner' => 'FedEx',
            'shipping_weight_grams' => 300,
            'shipping_cost' => 4000,
            'shipping_method' => 'FedEx',
            'tracking_number' => 'FDX908877',
            'delivery_status' => 'failed',
        ]);
    }
}
