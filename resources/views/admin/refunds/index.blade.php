@extends('admin.layouts.admin-app')

@section('content')
<div class="py-6 md:py-12">
    <div class="max-w-6xl mx-auto px-3 sm:px-6 lg:px-8">
        <div class="mb-6 md:mb-8">
            <h2 class="font-semibold text-2xl sm:text-3xl text-gray-800 dark:text-gray-200">Refund Management</h2>
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-2">
                Review refund requests and manage refund workflow
            </p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="mb-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
            <form action="{{ route('admin.refunds.index') }}" method="GET" class="space-y-4">
                <!-- Search Row -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Search Refunds</label>
                    <input
                        type="text"
                        name="search"
                        placeholder="Search by ticket ID, order number, customer name, email, phone, or reason..."
                        value="{{ $search ?? '' }}"
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 text-sm"
                    >
                </div>

                <!-- Filters Row -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Refund Status</label>
                        <select name="status" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm">
                            <option value="">All Statuses</option>
                            @foreach(($statusOptions ?? []) as $statusOption)
                                <option value="{{ $statusOption }}" {{ ($status ?? '') === $statusOption ? 'selected' : '' }}>
                                    {{ ucwords(str_replace('_', ' ', $statusOption)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">From Date</label>
                        <input
                            type="date"
                            name="date_from"
                            value="{{ $dateFrom ?? '' }}"
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">To Date</label>
                        <input
                            type="date"
                            name="date_to"
                            value="{{ $dateTo ?? '' }}"
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm"
                        >
                    </div>
                </div>

                <!-- Action Buttons Row -->
                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors text-sm font-semibold shadow-md hover:shadow-lg">
                        <i class="fa fa-search mr-2"></i>
                        Apply Filters
                    </button>
                    @if(($search ?? '') !== '' || ($status ?? '') !== '' || ($dateFrom ?? '') !== '' || ($dateTo ?? '') !== '')
                        <a href="{{ route('admin.refunds.index') }}" class="inline-flex items-center px-6 py-2.5 bg-gray-300 hover:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-lg transition-colors text-sm font-semibold">
                            <i class="fa fa-times mr-2"></i>
                            Clear Filters
                        </a>
                    @endif
                </div>
            </form>
        </div>

        @if($refunds->count() === 0)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700 text-gray-600 dark:text-gray-300">
                No refund requests found.
            </div>
        @else
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">Ticket ID</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">Order</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">Customer</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">Reason</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">Status</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">Date</th>
                                <th class="px-4 sm:px-6 py-3 text-center text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($refunds as $refund)
                                @php
                                    $statusColors = [
                                        'refund_requested' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                        'under_review' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                        'refund_approved' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                        'refund_rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                        'pending_customer_response' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300',
                                        'return_in_process' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300',
                                        'product_received' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300',
                                        'refund_completed' => 'bg-green-200 text-green-900 dark:bg-green-900/40 dark:text-green-300',
                                    ];
                                    $statusColor = $statusColors[$refund->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                                @endphp
                                <tr class="border-b border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-4 sm:px-6 py-3 whitespace-nowrap align-middle text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $refund->ticket_id ?? ('RFD-#' . $refund->id) }}</div>
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 align-middle">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100 leading-tight">{{ $refund->order?->order_number ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 align-middle">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100 leading-tight">{{ $refund->order?->customer_name ?? 'N/A' }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 leading-tight mt-0.5">{{ $refund->order?->email ?? '' }}</div>
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 align-middle">
                                        <div class="text-sm text-gray-900 dark:text-gray-100">{{ Str::limit($refund->reason, 30) }}</div>
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 whitespace-nowrap align-middle">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                            {{ ucwords(str_replace('_', ' ', $refund->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 align-middle">
                                        {{ $refund->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 whitespace-nowrap text-center align-middle">
                                        <a href="{{ route('admin.refunds.show', $refund) }}" 
                                           class="inline-flex items-center px-3 py-1.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-md hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors text-xs font-medium" 
                                           title="View Details">
                                            <i class="fa fa-eye text-base"></i>
                                            <span>View</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">
                {{ $refunds->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
