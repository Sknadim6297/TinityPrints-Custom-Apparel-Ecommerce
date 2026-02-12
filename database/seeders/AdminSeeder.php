<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin
        Admin::updateOrCreate(
            ['email' => 'admin@tinnity.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create Order Manager
        Admin::updateOrCreate(
            ['email' => 'orders@tinnity.com'],
            [
                'name' => 'Order Manager',
                'password' => Hash::make('password'),
                'role' => 'order_manager',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create Design Approver
        Admin::updateOrCreate(
            ['email' => 'design@tinnity.com'],
            [
                'name' => 'Design Approver',
                'password' => Hash::make('password'),
                'role' => 'design_approver',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
