@extends('admin.layouts.admin-app')

@section('content')
<div class="py-6 md:py-12">
    <div class="max-w-6xl mx-auto px-3 sm:px-6 lg:px-8">
        <div class="mb-6 md:mb-8">
            <h2 class="font-semibold text-2xl sm:text-3xl text-gray-800 dark:text-gray-200">Design Approvals</h2>
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-2">
                Review custom design requests and manage approvals
            </p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 sm:p-6 border border-gray-100 dark:border-gray-700">
            <form action="{{ route('admin.design-approvals.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1">
                    <input
                        type="text"
                        name="search"
                        placeholder="Search by customer, phone, email, status, size..."
                        value="{{ $search ?? '' }}"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 text-sm"
                    >
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors text-sm font-medium">
                        Search
                    </button>
                    @if($search)
                        <a href="{{ route('admin.design-approvals.index') }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-lg transition-colors text-sm font-medium">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        @if($designRequests->count() === 0)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700 text-gray-600 dark:text-gray-300">
                No design requests yet.
            </div>
        @else
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">Request ID</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">Customer</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">Size</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">Design</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">Status</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">Date</th>
                                <th class="px-4 sm:px-6 py-3 text-center text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($designRequests as $request)
                                @php
                                    $statusColors = [
                                        'approved' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                        'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                        'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                        'changes_requested' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300',
                                    ];
                                    $statusColor = $statusColors[$request->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';

                                    $frontPath = $request->front_design_file ?: $request->design_file_path;
                                    $backPath = $request->back_design_file;
                                    $frontExt = $frontPath ? strtolower(pathinfo($frontPath, PATHINFO_EXTENSION)) : null;
                                    $backExt = $backPath ? strtolower(pathinfo($backPath, PATHINFO_EXTENSION)) : null;
                                    $frontIsImage = in_array($frontExt, ['png', 'jpg', 'jpeg', 'webp']);
                                    $backIsImage = in_array($backExt, ['png', 'jpg', 'jpeg', 'webp']);
                                @endphp
                                <tr class="border-b border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-4 sm:px-6 py-3 whitespace-nowrap align-middle text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">#{{ $request->id }}</div>
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 align-middle">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100 leading-tight">{{ $request->customer_name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 leading-tight mt-0.5">{{ $request->phone }}</div>
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 whitespace-nowrap align-middle">
                                        <div class="text-sm text-gray-900 dark:text-gray-100">{{ $request->selected_size }}</div>
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 align-middle">
                                        <div class="flex items-center gap-3">
                                            @if($frontPath && $frontIsImage)
                                                <div class="flex flex-col items-center gap-0.5">
                                                    <img src="{{ Storage::url($frontPath) }}" alt="Front" class="w-8 h-8 object-cover bg-gray-100 dark:bg-gray-700 rounded border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow cursor-pointer" title="Front Design">
                                                    <span class="text-xs font-medium text-gray-600 dark:text-gray-400">F</span>
                                                </div>
                                            @endif
                                            @if($backPath && $backIsImage)
                                                <div class="flex flex-col items-center gap-0.5">
                                                    <img src="{{ Storage::url($backPath) }}" alt="Back" class="w-8 h-8 object-cover bg-gray-100 dark:bg-gray-700 rounded border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow cursor-pointer" title="Back Design">
                                                    <span class="text-xs font-medium text-gray-600 dark:text-gray-400">B</span>
                                                </div>
                                            @endif
                                            @if(!$frontPath && !$backPath)
                                                <span class="text-xs text-gray-400 italic">—</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 whitespace-nowrap align-middle">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                            {{ ucwords(str_replace('_', ' ', $request->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 align-middle">
                                        {{ $request->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 whitespace-nowrap text-center align-middle">
                                        <a href="{{ route('admin.design-approvals.show', $request) }}" 
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
                {{ $designRequests->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
