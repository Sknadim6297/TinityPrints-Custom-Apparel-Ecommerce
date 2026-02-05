<?php

namespace Database\Seeders;

use App\Models\DesignRequest;
use Illuminate\Database\Seeder;

class DesignRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DesignRequest::create([
            'customer_name' => 'Ayesha Khan',
            'phone' => '+92 300 1234567',
            'email' => 'ayesha.khan@example.com',
            'selected_size' => 'm',
            'design_file_path' => '/assets/logo.png',
            'front_label' => 'AYE-01',
            'back_label' => 'LIMITED DROP',
            'status' => 'pending',
            'remarks' => null,
            'payment_unlocked' => false,
        ]);

        DesignRequest::create([
            'customer_name' => 'John Carter',
            'phone' => '+1 415 555 1199',
            'email' => 'john.carter@example.com',
            'selected_size' => 'l',
            'design_file_path' => '/assets/logo.png',
            'front_label' => 'JC-78',
            'back_label' => 'CUSTOM ART',
            'status' => 'approved',
            'remarks' => 'Clean artwork. Print-ready.',
            'payment_unlocked' => true,
        ]);

        DesignRequest::create([
            'customer_name' => 'Sara Iqbal',
            'phone' => '+92 333 8889900',
            'email' => 'sara.iqbal@example.com',
            'selected_size' => 's',
            'design_file_path' => '/assets/logo.png',
            'front_label' => 'SI-12',
            'back_label' => 'SERIF LOGO',
            'status' => 'changes_requested',
            'remarks' => 'Please submit higher resolution file for print.',
            'payment_unlocked' => false,
        ]);

        DesignRequest::create([
            'customer_name' => 'Omar Sheikh',
            'phone' => '+92 321 4567890',
            'email' => 'omar.sheikh@example.com',
            'selected_size' => 'xl',
            'design_file_path' => '/assets/logo.png',
            'front_label' => 'OS-44',
            'back_label' => 'BACK PRINT',
            'status' => 'rejected',
            'remarks' => 'File contains low-contrast text; not readable in print.',
            'payment_unlocked' => false,
        ]);
    }
}
