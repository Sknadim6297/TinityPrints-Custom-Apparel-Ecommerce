@extends('admin.layouts.admin-app')

@section('content')
<div class="py-6 md:py-12">
    <div class="max-w-6xl mx-auto px-3 sm:px-6 lg:px-8">
        <div class="mb-6 md:mb-8">
            <h2 class="font-semibold text-2xl sm:text-3xl text-gray-800 dark:text-gray-200">Refund Management</h2>
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-2">
                Review refund requests, validate proof, and manage payment processing.
            </p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        @if($refunds->count() === 0)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700 text-gray-600 dark:text-gray-300">
                No refund requests found.
            </div>
        @else
            <div class="space-y-4">
                @foreach($refunds as $refund)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 sm:p-6 border border-gray-100 dark:border-gray-700">
                        <div class="flex flex-col lg:flex-row lg:items-start gap-4">
                            <div class="lg:w-60">
                                <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-700/40 border border-gray-200 dark:border-gray-600">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Refund ID</p>
                                    <p class="text-lg font-bold text-gray-900 dark:text-gray-100">#{{ $refund->id }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">Status</p>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ ucwords($refund->status) }}</p>
                                </div>
                            </div>

                            <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Order</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $refund->order?->order_number ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Customer</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $refund->order?->customer_name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Email</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $refund->order?->email ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Order Status</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $refund->order?->order_status ? ucwords(str_replace('_', ' ', $refund->order->order_status)) : 'N/A' }}
                                    </p>
                                </div>
                                <div class="sm:col-span-2">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Refund Reason</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $refund->reason }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Proof</p>
                                    @if($refund->proof_path)
                                        <a href="{{ asset('storage/' . ltrim($refund->proof_path, '/')) }}" target="_blank" class="text-sm font-semibold text-blue-600 hover:text-blue-700">View Proof</a>
                                    @else
                                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-300">No proof</p>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Requested</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $refund->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('admin.refunds.status', $refund) }}" class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                            @csrf
                            @method('PATCH')
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Refund Status</label>
                                <select name="status" class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    @foreach(['requested', 'approved', 'rejected', 'paid'] as $status)
                                        <option value="{{ $status }}" {{ $refund->status === $status ? 'selected' : '' }}>
                                            {{ ucwords($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Admin Note</label>
                                <input type="text" name="admin_note" value="{{ $refund->admin_note }}"
                                       class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            </div>
                            <div class="sm:col-span-2 lg:col-span-1 flex items-end">
                                <button type="submit" class="w-full px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-semibold text-sm">
                                    Update Status
                                </button>
                            </div>
                        </form>

                        <div class="mt-4 flex flex-col sm:flex-row gap-2">
                            <form method="POST" action="{{ route('admin.refunds.approve', $refund) }}" class="w-full sm:w-auto">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="w-full sm:w-auto px-4 py-2 rounded-lg font-semibold text-sm border border-emerald-600 bg-emerald-600 hover:bg-emerald-700 text-white">
                                    Approve Refund
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.refunds.reject', $refund) }}" class="w-full sm:w-auto">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="w-full sm:w-auto px-4 py-2 rounded-lg font-semibold text-sm border border-rose-600 bg-rose-600 hover:bg-rose-700 text-white">
                                    Reject Refund
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.refunds.paid', $refund) }}" class="w-full sm:w-auto">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="w-full sm:w-auto px-4 py-2 rounded-lg font-semibold text-sm border border-blue-600 bg-blue-600 hover:bg-blue-700 text-white">
                                    Process Refund Payment
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $refunds->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
