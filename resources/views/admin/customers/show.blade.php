@extends('admin.layouts.admin-app')

@section('content')
<div class="py-6 md:py-12">
    <div class="max-w-6xl mx-auto px-3 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-6 md:mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
            <div>
                <h2 class="font-semibold text-2xl sm:text-3xl text-gray-800 dark:text-gray-200">
                    {{ $customer->name }}
                </h2>
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Customer ID: #{{ $customer->id }}
                </p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.customers.edit', $customer) }}" 
                   class="inline-flex items-center bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-7.5-1.5L14.5 4m0 0l3 3m-3-3v9" />
                    </svg>
                    Edit
                </a>
                <a href="{{ route('admin.customers.history', $customer) }}" 
                   class="inline-flex items-center bg-purple-500 hover:bg-purple-600 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    History
                </a>
                <a href="{{ route('admin.customers.index') }}" 
                   class="inline-flex items-center bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back
                </a>
            </div>
        </div>

        <!-- Basic Info and Stats Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
            <!-- Basic Information -->
            <div class="lg:col-span-1 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 mb-4">Basic Information</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Email</p>
                        <p class="text-sm font-medium text-blue-600 dark:text-blue-400">
                            <a href="mailto:{{ $customer->email }}" class="hover:underline">{{ $customer->email }}</a>
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Phone</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $customer->phone ?? 'Not provided' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Email Verified</p>
                        <div>
                            @if($customer->email_verified_at)
                                <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-semibold rounded-full">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    Yes ({{ $customer->email_verified_at->format('M d, Y') }})
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 text-xs font-semibold rounded-full">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    Not Verified
                                </span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Member Since</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $customer->created_at->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Last Updated</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $customer->updated_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-3 gap-4">
                <!-- Total Reviews -->
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-90 mb-1">Total Reviews</p>
                            <p class="text-3xl font-bold">{{ $reviews->count() }}</p>
                        </div>
                        <svg class="w-10 h-10 opacity-30" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </div>
                </div>

                <!-- Member Since -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-90 mb-1">Member For</p>
                            <p class="text-2xl font-bold">{{ now()->diffInDays($customer->created_at) }}</p>
                            <p class="text-xs opacity-75">days</p>
                        </div>
                        <svg class="w-10 h-10 opacity-30" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v2H4a2 2 0 00-2 2v2h16V7a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v2H7V3a1 1 0 00-1-1zm0 5a2 2 0 002 2h8a2 2 0 002-2H6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>

                <!-- Last Login -->
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-90 mb-1">Last Login</p>
                            @if($loginHistory->isNotEmpty())
                                <p class="text-sm font-bold">{{ $loginHistory->first()->login_time->diffForHumans() }}</p>
                                <p class="text-xs opacity-75">{{ $loginHistory->first()->login_time->format('M d, Y') }}</p>
                            @else
                                <p class="text-sm font-bold">Never</p>
                            @endif
                        </div>
                        <svg class="w-10 h-10 opacity-30" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Reviews Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 p-6 mb-6">
            <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 mb-4">Recent Reviews</h3>
            @if($reviews->isNotEmpty())
                <div class="space-y-4">
                    @foreach($reviews as $review)
                        <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600">
                            <div class="flex justify-between items-start gap-3">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-2">
                                        {{ $review->product->name ?? 'Product Deleted' }}
                                    </h4>
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="flex gap-0.5">
                                            @for($i = 0; $i < 5; $i++)
                                                <svg class="w-4 h-4 {{ $i < $review->rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @endfor
                                        </div>
                                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ $review->rating }}/5</span>
                                    </div>
                                    <p class="text-sm text-gray-700 dark:text-gray-300 mb-2">{{ $review->comment }}</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">{{ $review->created_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-12 h-12 mx-auto text-gray-400 dark:text-gray-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v12a2 2 0 01-2 2h-3l-4 4z" />
                    </svg>
                    <p class="text-gray-600 dark:text-gray-400">No reviews yet</p>
                </div>
            @endif
        </div>

        <!-- Orders Info -->
        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-800 p-6 mb-6">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
                <div>
                    <h4 class="font-semibold text-blue-900 dark:text-blue-300 mb-1">Order Tracking</h4>
                    <p class="text-sm text-blue-800 dark:text-blue-400">Orders are tracked separately in the Orders Management section. Check the Orders Management for all customer orders.</p>
                </div>
            </div>
        </div>

        <!-- Delete Customer -->
        <div class="flex justify-end">
            <button 
                onclick="openDeleteModal('{{ $customer->name }}')"
                class="inline-flex items-center bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg transition-colors"
            >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Delete Customer
            </button>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black/50 dark:bg-black/70 z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-md w-full">
        <div class="p-6">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 dark:bg-red-900/30 rounded-full mb-4">
                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 4v2M6.343 3L3 20.364A3.5 3.5 0 006.343 21h11.314a3.5 3.5 0 003.368-4.728L17.632 3H6.343z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2 text-center">Delete Customer</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4 text-center">
                Are you sure you want to permanently delete <span id="customerName" class="font-semibold"></span>?
            </p>
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-3 mb-4">
                <p class="text-xs text-red-800 dark:text-red-300 font-medium">This action cannot be undone. The following data will be deleted:</p>
                <ul class="text-xs text-red-700 dark:text-red-400 list-disc list-inside mt-2 space-y-1">
                    <li>Orders and order history</li>
                    <li>All reviews</li>
                    <li>Wishlist items</li>
                    <li>Cart items</li>
                    <li>Login history</li>
                </ul>
            </div>
        </div>
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700 flex gap-3 justify-end rounded-b-xl">
            <button 
                onclick="closeDeleteModal()"
                class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 rounded-lg transition-colors font-medium"
            >
                Cancel
            </button>
            <form id="deleteForm" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button 
                    type="submit"
                    class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors font-medium"
                >
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function openDeleteModal(name) {
    document.getElementById('customerName').textContent = name;
    document.getElementById('deleteForm').action = '{{ route('admin.customers.destroy', $customer) }}';
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});
</script>
@endsection
