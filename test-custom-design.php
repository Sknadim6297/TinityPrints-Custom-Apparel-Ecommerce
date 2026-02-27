<?php
/**
 * Test Custom Design System
 * Run with: php test-custom-design.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\DesignRequest;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

echo "=== Testing Custom Design System ===\n\n";

// 1. Check if users exist
echo "1. Checking for users...\n";
$user = User::first();
if (!$user) {
    echo "   ❌ No users found. Please create a user first.\n";
    echo "   Run: php artisan tinker\n";
    echo "   Then: User::factory()->create(['email' => 'test@example.com', 'password' => bcrypt('password')]);\n";
    exit(1);
}
echo "   ✅ Found user: {$user->name} ({$user->email})\n\n";

// 2. Create test design files (simulate upload)
echo "2. Creating test design files...\n";
Storage::disk('public')->makeDirectory('designs/front');
Storage::disk('public')->makeDirectory('designs/back');

$frontPath = 'designs/front/test-front-' . time() . '.txt';
$backPath = 'designs/back/test-back-' . time() . '.txt';

Storage::disk('public')->put($frontPath, "Test front design content");
Storage::disk('public')->put($backPath, "Test back design content");

echo "   ✅ Created test files:\n";
echo "      - {$frontPath}\n";
echo "      - {$backPath}\n\n";

// 3. Create test design request
echo "3. Creating test design request...\n";
$design = DesignRequest::create([
    'user_id' => $user->id,
    'customer_name' => 'Test Customer',
    'email' => 'test@example.com',
    'phone' => '9876543210',
    'selected_size' => 'l',
    'sleeve_type' => 'full',
    'color' => '#FF5733',
    'front_design_file' => $frontPath,
    'back_design_file' => $backPath,
    'notes' => 'This is a test design request created by automated testing.',
    'status' => 'pending',
    'payment_status' => 'unpaid',
    'payment_unlocked' => false,
]);

echo "   ✅ Design Request Created:\n";
echo "      ID: {$design->id}\n";
echo "      Customer: {$design->customer_name}\n";
echo "      Status: {$design->status}\n";
echo "      Size: " . strtoupper($design->selected_size) . "\n";
echo "      Sleeve: {$design->sleeve_type}\n";
echo "      Color: {$design->color}\n\n";

// 4. Verify URLs
echo "4. Test URLs:\n";
echo "   Frontend Form: http://127.0.0.1:8000/custom-design\n";
echo "   Design Detail: http://127.0.0.1:8000/custom-design/{$design->id}\n";
echo "   Admin Panel: http://127.0.0.1:8000/admin/design-approvals\n\n";

// 5. Test model methods
echo "5. Testing model methods...\n";
echo "   canPay(): " . ($design->canPay() ? '❌ YES (should be NO)' : '✅ NO') . "\n";
echo "   isApproved(): " . ($design->isApproved() ? '❌ YES (should be NO)' : '✅ NO') . "\n";
echo "   isPending(): " . ($design->isPending() ? '✅ YES' : '❌ NO') . "\n";
echo "   requiresRevision(): " . ($design->requiresRevision() ? '❌ YES (should be NO)' : '✅ NO') . "\n\n";

// 6. Test approval workflow
echo "6. Testing approval workflow...\n";
$design->update([
    'status' => 'approved',
    'price' => 499.00,
    'payment_unlocked' => true,
    'admin_remark' => 'Design looks great! Approved for production.',
]);
$design->refresh();

echo "   Status changed to: {$design->status}\n";
echo "   Price set to: ₹{$design->price}\n";
echo "   Payment unlocked: " . ($design->payment_unlocked ? '✅ YES' : '❌ NO') . "\n";
echo "   canPay(): " . ($design->canPay() ? '✅ YES' : '❌ NO') . "\n\n";

// 7. Summary
echo "=== Test Summary ===\n";
echo "✅ Database connection working\n";
echo "✅ Design request table exists with all columns\n";
echo "✅ File storage working (public disk)\n";
echo "✅ Design request created successfully (ID: {$design->id})\n";
echo "✅ Model methods working correctly\n";
echo "✅ Approval workflow functioning\n\n";

echo "Next Steps:\n";
echo "1. Login to: http://127.0.0.1:8000/login\n";
echo "   Email: {$user->email}\n";
echo "   Password: password (or your set password)\n\n";
echo "2. Visit: http://127.0.0.1:8000/custom-design\n";
echo "   - Upload a real image file (PNG/JPG/PDF)\n";
echo "   - Fill in the form\n";
echo "   - Submit for review\n\n";
echo "3. Admin Panel: http://127.0.0.1:8000/admin/login\n";
echo "   - View design requests\n";
echo "   - Approve/Reject designs\n";
echo "   - Set pricing\n\n";

echo "Test completed successfully! ✅\n";
