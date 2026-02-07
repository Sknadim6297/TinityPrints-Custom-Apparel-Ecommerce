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
                                $path = $request->design_file_path;
                                $previewUrl = (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '/'))
                                    ? $path
                                    : Storage::url($path);
                                $fileExt = $request->file_format ?: strtolower(pathinfo($path, PATHINFO_EXTENSION));
                                $isImage = in_array($fileExt, ['png', 'jpg', 'jpeg', 'webp']);
                            @endphp
                            <div class="sm:w-56 lg:w-40">
                                @if($isImage)
                                    <img src="{{ $previewUrl }}" alt="Design preview" class="w-full h-32 sm:h-36 lg:h-28 object-contain bg-gray-50 dark:bg-gray-700/40 rounded-lg border border-gray-200 dark:border-gray-600">
                                @else
                                    <div class="w-full h-32 sm:h-36 lg:h-28 flex items-center justify-center bg-gray-50 dark:bg-gray-700/40 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <span class="text-xs font-semibold text-gray-600 dark:text-gray-300">
                                            {{ strtoupper($fileExt ?: 'FILE') }}
                                        </span>
                                    </div>
                                @endif
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Design File Preview</p>
                                <a href="{{ $previewUrl }}" class="mt-2 inline-flex items-center text-xs font-semibold text-yellow-600 dark:text-yellow-400 hover:text-yellow-700" download>
                                    Download print-ready design
                                </a>
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
                            </div>
                        </div>

                        <div class="mt-4 grid grid-cols-1 lg:grid-cols-3 gap-3">
                            <div class="lg:col-span-2 rounded-lg border border-gray-200 dark:border-gray-700 p-4 bg-gray-50 dark:bg-gray-700/30">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="text-sm font-bold text-gray-800 dark:text-gray-200">Print File Checks</h4>
                                    <span class="text-xs font-semibold {{ $request->file_locked ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400' }}">
                                        {{ $request->file_locked ? 'File Locked' : 'File Unlocked' }}
                                    </span>
                                </div>
                                <form method="POST" action="{{ route('admin.design-approvals.update-checks', $request) }}" class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    @csrf
                                    @method('PATCH')
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Format (PNG / PSD / AI)</label>
                                        <select name="file_format" class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                            <option value="">Select</option>
                                            @foreach(['png', 'psd', 'ai'] as $format)
                                                <option value="{{ $format }}" {{ ($request->file_format === $format || $fileExt === $format) ? 'selected' : '' }}>
                                                    {{ strtoupper($format) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">DPI</label>
                                        <input type="number" name="dpi" value="{{ $request->dpi }}" min="72" max="1200"
                                               class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Print Width</label>
                                        <input type="number" name="print_width" value="{{ $request->print_width }}" step="0.01" min="0.1"
                                               class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Print Height</label>
                                        <input type="number" name="print_height" value="{{ $request->print_height }}" step="0.01" min="0.1"
                                               class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">Unit</label>
                                        <select name="print_unit" class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                            @foreach(['in' => 'Inches', 'cm' => 'Centimeters', 'mm' => 'Millimeters'] as $unit => $label)
                                                <option value="{{ $unit }}" {{ $request->print_unit === $unit ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="sm:col-span-2 flex justify-end">
                                        <button type="submit" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-semibold text-sm">
                                            Save File Checks
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                                <h4 class="text-sm font-bold text-gray-800 dark:text-gray-200 mb-3">File Management</h4>
                                <form method="POST" action="{{ route('admin.design-approvals.update-file', $request) }}" enctype="multipart/form-data" class="space-y-3">
                                    @csrf
                                    <input type="file" name="design_file" accept=".png,.psd,.ai" class="w-full text-xs text-gray-700 dark:text-gray-200">
                                    <button type="submit" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold text-sm">
                                        Replace File (Re-approval Required)
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.design-approvals.toggle-lock', $request) }}" class="mt-3">
                                    @csrf
                                    <input type="hidden" name="locked" value="{{ $request->file_locked ? 0 : 1 }}">
                                    <button type="submit" class="w-full px-4 py-2 {{ $request->file_locked ? 'bg-gray-600 hover:bg-gray-700' : 'bg-green-600 hover:bg-green-700' }} text-white rounded-lg font-semibold text-sm">
                                        {{ $request->file_locked ? 'Unlock File' : 'Lock File' }}
                                    </button>
                                </form>
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
