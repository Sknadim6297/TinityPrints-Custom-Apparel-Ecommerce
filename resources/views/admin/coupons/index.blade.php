@extends('admin.layouts.admin-app')

@section('content')
<div class="py-6 md:py-12">
    <div class="max-w-6xl mx-auto px-3 sm:px-6 lg:px-8">
        <div class="mb-6 md:mb-8">
            <h2 class="font-semibold text-2xl sm:text-3xl text-gray-800 dark:text-gray-200">Coupon Management</h2>
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-2">
                Create and manage coupon codes with discount rules and restrictions.
            </p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 sm:p-6 border border-gray-100 dark:border-gray-700 mb-6">
            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">Create Coupon</h3>
            <form method="POST" action="{{ route('admin.coupons.store') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Coupon Code</label>
                    <input type="text" name="code" required
                           class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Discount Type</label>
                    <select name="discount_type" required
                            class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <option value="flat">Flat (₹)</option>
                        <option value="percentage">Percentage (%)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Discount Value</label>
                    <input type="number" name="discount_value" step="0.01" min="0.01" required
                           class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Usage Limit</label>
                    <input type="number" name="usage_limit" min="1"
                           class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Expiry Date</label>
                    <input type="datetime-local" name="expires_at"
                           class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Minimum Order Value</label>
                    <input type="number" name="min_order_value" step="0.01" min="0"
                           class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Customer Email (Optional)</label>
                    <input type="email" name="customer_email"
                           class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" checked
                           class="w-4 h-4 rounded border-gray-300 dark:border-gray-600 text-red-600 focus:ring-red-500 dark:focus:ring-red-400 dark:bg-gray-700">
                    <label class="ml-2 text-sm text-gray-700 dark:text-gray-300">Enable Coupon</label>
                </div>
                <div class="lg:col-span-3 flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-semibold text-sm">
                        Create Coupon
                    </button>
                </div>
            </form>
        </div>

        @if($coupons->count() === 0)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700 text-gray-600 dark:text-gray-300">
                No coupons found.
            </div>
        @else
            <div class="space-y-3">
                @foreach($coupons as $coupon)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 border border-gray-100 dark:border-gray-700">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 flex-1">
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Code</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $coupon->code }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Discount</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $coupon->discount_type === 'flat' ? '₹' : '' }}{{ $coupon->discount_value }}{{ $coupon->discount_type === 'percentage' ? '%' : '' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Usage</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $coupon->usage_count }}{{ $coupon->usage_limit ? ' / ' . $coupon->usage_limit : '' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Expiry</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $coupon->expires_at ? $coupon->expires_at->format('M d, Y') : 'No Expiry' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Min Order</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $coupon->min_order_value ? '₹' . $coupon->min_order_value : 'None' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Customer</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $coupon->customer_email ?? 'All' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Status</p>
                                    <p class="font-semibold {{ $coupon->is_active ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400' }}">
                                        {{ $coupon->is_active ? 'Enabled' : 'Disabled' }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row gap-2 sm:items-center">
                                <a href="{{ route('admin.coupons.edit', $coupon) }}" class="w-full sm:w-auto px-4 py-2 rounded-lg font-semibold text-sm text-center border border-amber-600 bg-amber-500 hover:bg-amber-600 text-white dark:border-amber-400 dark:bg-amber-400 dark:hover:bg-amber-500">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.coupons.toggle', $coupon) }}" class="w-full sm:w-auto">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-full sm:w-auto px-4 py-2 rounded-lg font-semibold text-sm border {{ $coupon->is_active ? 'border-slate-600 bg-slate-600 hover:bg-slate-700 text-white dark:border-slate-400 dark:bg-slate-400 dark:hover:bg-slate-500' : 'border-emerald-600 bg-emerald-600 hover:bg-emerald-700 text-white dark:border-emerald-400 dark:bg-emerald-400 dark:hover:bg-emerald-500' }}">
                                        {{ $coupon->is_active ? 'Disable' : 'Enable' }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.coupons.destroy', $coupon) }}" class="w-full sm:w-auto" onsubmit="return confirm('Are you sure you want to delete this coupon?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full sm:w-auto px-4 py-2 rounded-lg font-semibold text-sm border border-rose-600 bg-rose-600 hover:bg-rose-700 text-white dark:border-rose-400 dark:bg-rose-400 dark:hover:bg-rose-500">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $coupons->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
