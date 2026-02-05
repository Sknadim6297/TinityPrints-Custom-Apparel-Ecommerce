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
        Admin::create([
            'name' => 'Super Admin',
            'email' => 'admin@tinnity.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Create Order Manager
        Admin::create([
            'name' => 'Order Manager',
            'email' => 'orders@tinnity.com',
            'password' => Hash::make('password'),
            'role' => 'order_manager',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Create Design Approver
        Admin::create([
            'name' => 'Design Approver',
            'email' => 'design@tinnity.com',
            'password' => Hash::make('password'),
            'role' => 'design_approver',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
    }
}
