<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\RefundRequest;
use Illuminate\Database\Seeder;

class RefundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $order = Order::first();

        if ($order) {
            RefundRequest::updateOrCreate([
                'order_id' => $order->id,
            ], [
                'reason' => 'Wrong size delivered. Requested M, received L.',
                'status' => 'requested',
                'admin_note' => null,
            ]);
        }
    }
}
