@extends('admin.layouts.admin-app')

@section('content')
<div class="py-6 md:py-12">
    <div class="max-w-6xl mx-auto px-3 sm:px-6 lg:px-8">
        <div class="mb-6 md:mb-8">
            <h2 class="font-semibold text-2xl sm:text-3xl text-gray-800 dark:text-gray-200">Design Approvals</h2>
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-2">
                Review custom designs and unlock payment only after approval.
            </p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        @if($designRequests->count() === 0)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700 text-gray-600 dark:text-gray-300">
                No design requests yet.
            </div>
        @else
            <div class="space-y-4">
                @foreach($designRequests as $request)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 sm:p-6 border border-gray-100 dark:border-gray-700">
                        <div class="flex flex-col lg:flex-row lg:items-start gap-4">
                            @php
                                $frontPath = $request->front_design_file ?: $request->design_file_path;
                                $backPath = $request->back_design_file;

                                $frontExt = $frontPath ? strtolower(pathinfo($frontPath, PATHINFO_EXTENSION)) : null;
                                $backExt = $backPath ? strtolower(pathinfo($backPath, PATHINFO_EXTENSION)) : null;

                                $frontIsImage = in_array($frontExt, ['png', 'jpg', 'jpeg', 'webp']);
                                $backIsImage = in_array($backExt, ['png', 'jpg', 'jpeg', 'webp']);

                                $frontPreviewUrl = $frontPath ? Storage::url($frontPath) : null;
                                $backPreviewUrl = $backPath ? Storage::url($backPath) : null;

                                $fileExt = $request->file_format ?: ($frontExt ?: null);
                            @endphp
                            <div class="sm:w-56 lg:w-52 space-y-3">
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Front Design File</p>
                                    @if($frontPath)
                                        @if($frontIsImage && $frontPreviewUrl)
                                            <img src="{{ $frontPreviewUrl }}" alt="Front design preview" class="w-full h-28 object-contain bg-gray-50 dark:bg-gray-700/40 rounded-lg border border-gray-200 dark:border-gray-600">
                                        @else
                                            <div class="w-full h-28 flex items-center justify-center bg-gray-50 dark:bg-gray-700/40 rounded-lg border border-gray-200 dark:border-gray-600">
                                                <span class="text-xs font-semibold text-gray-600 dark:text-gray-300">
                                                    {{ strtoupper($frontExt ?: 'FILE') }}
                                                </span>
                                            </div>
                                        @endif
                                        <a href="{{ route('admin.design-approvals.download', [$request, 'front']) }}" class="mt-2 inline-flex items-center text-xs font-semibold text-yellow-600 dark:text-yellow-400 hover:text-yellow-700">
                                            Download Front Design
                                        </a>
                                    @else
                                        <div class="w-full h-28 flex items-center justify-center bg-gray-50 dark:bg-gray-700/40 rounded-lg border border-gray-200 dark:border-gray-600 text-xs text-gray-500 dark:text-gray-400">
                                            Not uploaded
                                        </div>
                                    @endif
                                </div>

                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Back Design File</p>
                                    @if($backPath)
                                        @if($backIsImage && $backPreviewUrl)
                                            <img src="{{ $backPreviewUrl }}" alt="Back design preview" class="w-full h-28 object-contain bg-gray-50 dark:bg-gray-700/40 rounded-lg border border-gray-200 dark:border-gray-600">
                                        @else
                                            <div class="w-full h-28 flex items-center justify-center bg-gray-50 dark:bg-gray-700/40 rounded-lg border border-gray-200 dark:border-gray-600">
                                                <span class="text-xs font-semibold text-gray-600 dark:text-gray-300">
                                                    {{ strtoupper($backExt ?: 'FILE') }}
                                                </span>
                                            </div>
                                        @endif
                                        <a href="{{ route('admin.design-approvals.download', [$request, 'back']) }}" class="mt-2 inline-flex items-center text-xs font-semibold text-yellow-600 dark:text-yellow-400 hover:text-yellow-700">
                                            Download Back Design
                                        </a>
                                    @else
                                        <div class="w-full h-28 flex items-center justify-center bg-gray-50 dark:bg-gray-700/40 rounded-lg border border-gray-200 dark:border-gray-600 text-xs text-gray-500 dark:text-gray-400">
                                            Not uploaded
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Customer Name</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $request->customer_name }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Phone</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $request->phone }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Email</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $request->email }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Selected Size</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ strtoupper($request->selected_size) }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Front Label</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $request->front_label ?? '—' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Back Label</p>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $request->back_label ?? '—' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Status</p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $request->status === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200' : '' }}
                                        {{ $request->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200' : '' }}
                                        {{ $request->status === 'rejected' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-200' : '' }}
                                        {{ $request->status === 'changes_requested' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-200' : '' }}
                                    ">
                                        {{ ucwords(str_replace('_', ' ', $request->status)) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Payment</p>
                                    <p class="font-semibold {{ $request->payment_unlocked ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400' }}">
                                        {{ $request->payment_unlocked ? 'Unlocked' : 'Locked' }}
                                    </p>
                                </div>
                                @if($request->price)
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Price</p>
                                    <p class="font-bold text-lg text-green-600 dark:text-green-400">
                                        ₹{{ number_format($request->price, 2) }}
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>



                        <div class="mt-4">
                            <label for="remarks_{{ $request->id }}" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Add Remarks
                            </label>
                            <textarea id="remarks_{{ $request->id }}" name="remarks" rows="2"
                                      form="design-action-{{ $request->id }}"
                                      class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400"
                                      placeholder="Remarks for approval, rejection or changes...">{{ old('remarks') }}</textarea>
                        </div>

                        <div class="mt-4">
                            <label for="price_{{ $request->id }}" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Design Price (₹) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   id="price_{{ $request->id }}" 
                                   name="price" 
                                   form="design-action-{{ $request->id }}"
                                   value="{{ old('price', $request->price) }}"
                                   min="1" 
                                   step="0.01"
                                   required
                                   class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400"
                                   placeholder="Enter price (e.g., 499.00)">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Required for approval. This will be shown to the customer.</p>
                        </div>

                        <div class="mt-4 flex flex-col sm:flex-row gap-2">
                            <form id="design-action-{{ $request->id }}" method="POST" action="{{ route('admin.design-approvals.approve', $request) }}" class="inline">
                                @csrf
                                <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold text-sm">
                                    Approve Design
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.design-approvals.reject', $request) }}" class="inline">
                                @csrf
                                <input type="hidden" name="remarks" value="" />
                                <button type="submit" onclick="this.closest('form').querySelector('input[name=remarks]').value = document.getElementById('remarks_{{ $request->id }}').value;" class="w-full sm:w-auto px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold text-sm">
                                    Reject Design
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.design-approvals.request-changes', $request) }}" class="inline">
                                @csrf
                                <input type="hidden" name="remarks" value="" />
                                <button type="submit" onclick="this.closest('form').querySelector('input[name=remarks]').value = document.getElementById('remarks_{{ $request->id }}').value;" class="w-full sm:w-auto px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold text-sm">
                                    Request Changes
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $designRequests->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
