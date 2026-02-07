<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Coupon::create([
            'code' => 'WELCOME200',
            'discount_type' => 'flat',
            'discount_value' => 200,
            'usage_limit' => 100,
            'expires_at' => now()->addMonths(2),
            'min_order_value' => 1000,
            'customer_email' => null,
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'VIP20',
            'discount_type' => 'percentage',
            'discount_value' => 20,
            'usage_limit' => 50,
            'expires_at' => now()->addMonths(1),
            'min_order_value' => 2000,
            'customer_email' => 'ayesha.khan@example.com',
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'FREESHIP',
            'discount_type' => 'flat',
            'discount_value' => 150,
            'usage_limit' => null,
            'expires_at' => null,
            'min_order_value' => 500,
            'customer_email' => null,
            'is_active' => false,
        ]);
    }
}
