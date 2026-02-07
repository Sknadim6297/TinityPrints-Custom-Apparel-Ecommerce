@extends('admin.layouts.admin-app')

@section('content')
<div class="py-6 md:py-12">
    <div class="max-w-6xl mx-auto px-3 sm:px-6 lg:px-8">
        <div class="mb-6 md:mb-8">
            <h2 class="font-semibold text-2xl sm:text-3xl text-gray-800 dark:text-gray-200">Edit Coupon</h2>
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-2">
                Update the coupon details.
            </p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 sm:p-6 border border-gray-100 dark:border-gray-700">
            <form method="POST" action="{{ route('admin.coupons.update', $coupon) }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                @csrf
                @method('PATCH')
                <div>
                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Coupon Code</label>
                    <input type="text" name="code" value="{{ $coupon->code }}" required
                           class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Discount Type</label>
                    <select name="discount_type" required
                            class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <option value="flat" {{ $coupon->discount_type === 'flat' ? 'selected' : '' }}>Flat (₹)</option>
                        <option value="percentage" {{ $coupon->discount_type === 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Discount Value</label>
                    <input type="number" name="discount_value" value="{{ $coupon->discount_value }}" step="0.01" min="0.01" required
                           class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Usage Limit</label>
                    <input type="number" name="usage_limit" value="{{ $coupon->usage_limit }}" min="1"
                           class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Expiry Date</label>
                    <input type="datetime-local" name="expires_at" value="{{ $coupon->expires_at ? $coupon->expires_at->format('Y-m-d\TH:i') : '' }}"
                           class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Minimum Order Value</label>
                    <input type="number" name="min_order_value" value="{{ $coupon->min_order_value }}" step="0.01" min="0"
                           class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Customer Email (Optional)</label>
                    <input type="email" name="customer_email" value="{{ $coupon->customer_email }}"
                           class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ $coupon->is_active ? 'checked' : '' }}
                           class="w-4 h-4 rounded border-gray-300 dark:border-gray-600 text-red-600 focus:ring-red-500 dark:focus:ring-red-400 dark:bg-gray-700">
                    <label class="ml-2 text-sm text-gray-700 dark:text-gray-300">Enable Coupon</label>
                </div>
                <div class="lg:col-span-3 flex justify-between">
                    <a href="{{ route('admin.coupons.index') }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg font-semibold text-sm">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-semibold text-sm">
                        Update Coupon
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection