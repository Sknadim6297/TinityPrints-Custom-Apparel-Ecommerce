@extends('admin.layouts.admin-app')

@section('content')
<div class="py-6 md:py-12">
    <div class="max-w-6xl mx-auto px-3 sm:px-6 lg:px-8">
        <div class="mb-6 md:mb-8">
            <h2 class="font-semibold text-2xl sm:text-3xl text-gray-800 dark:text-gray-200">Order Management</h2>
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-2">
                Track and manage all customer orders
            </p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 sm:p-6 border border-gray-100 dark:border-gray-700">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1">
                    <input
                        type="text"
                        name="search"
                        placeholder="Search by order ID, customer, phone, email, status..."
                        value="{{ $search ?? '' }}"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 text-sm"
                    >
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors text-sm font-medium">
                        Search
                    </button>
                    @if($search)
                        <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-lg transition-colors text-sm font-medium">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        @if($orders->count() === 0)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700 text-gray-600 dark:text-gray-300">
                No orders found.
            </div>
        @else
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">Order ID</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">Customer</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">Amount</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">Status</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">Payment</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">Order Date</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">Delivered Date</th>
                                <th class="px-4 sm:px-6 py-3 text-center text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                @php
                                    $statusColors = [
                                        'delivered' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                        'shipped' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                        'packed' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300',
                                        'printing' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300',
                                        'paid' => 'bg-teal-100 text-teal-800 dark:bg-teal-900/30 dark:text-teal-300',
                                        'payment_pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                        'refund_requested' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300',
                                        'under_review' => 'bg-cyan-100 text-cyan-800 dark:bg-cyan-900/30 dark:text-cyan-300',
                                        'refund_approved' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300',
                                        'refund_rejected' => 'bg-rose-100 text-rose-800 dark:bg-rose-900/30 dark:text-rose-300',
                                        'return_in_process' => 'bg-sky-100 text-sky-800 dark:bg-sky-900/30 dark:text-sky-300',
                                        'product_received' => 'bg-slate-100 text-slate-800 dark:bg-slate-900/30 dark:text-slate-300',
                                        'refund_completed' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                        'refunded' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                    ];
                                    $statusColor = $statusColors[$order->order_status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                                    
                                    $paymentColors = [
                                        'paid' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                        'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                        'refunded' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                    ];
                                    $paymentColor = $paymentColors[$order->payment_status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                                @endphp
                                <tr class="border-b border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-4 sm:px-6 py-3 whitespace-nowrap align-middle text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">#{{ $order->order_number }}</div>
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 align-middle">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100 leading-tight">{{ $order->customer_name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 leading-tight mt-0.5">{{ $order->phone }}</div>
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 whitespace-nowrap align-middle">
                                        <div class="text-sm font-semibold text-green-600 dark:text-green-400">₹{{ number_format($order->total_amount ?? 0, 2) }}</div>
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 whitespace-nowrap align-middle">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                            {{ ucwords(str_replace('_', ' ', $order->order_status)) }}
                                        </span>
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 whitespace-nowrap align-middle">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $paymentColor }}">
                                            {{ ucwords($order->payment_status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 align-middle">
                                        <div class="text-sm text-gray-900 dark:text-gray-100">{{ $order->created_at->format('M d, Y') }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $order->created_at->format('h:i A') }}</div>
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 align-middle">
                                        @if($order->delivered_date)
                                            <div class="text-sm text-green-600 dark:text-green-400">{{ $order->delivered_date->format('M d, Y') }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $order->delivered_date->format('h:i A') }}</div>
                                        @else
                                            <span class="text-sm text-gray-400 dark:text-gray-600">Not delivered</span>
                                        @endif
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 whitespace-nowrap text-center align-middle">
                                        <a href="{{ route('admin.orders.show', $order) }}" 
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
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
