@extends('admin.layouts.admin-app')

@section('content')
<div class="py-6 md:py-12">
    <div class="max-w-6xl mx-auto px-3 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-6 md:mb-8">
            <h2 class="font-semibold text-2xl sm:text-3xl text-gray-800 dark:text-gray-200">
                Contact Messages
            </h2>
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-2">
                View and manage customer contact inquiries.
            </p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        @if($contacts->count() === 0)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700 text-gray-600 dark:text-gray-300">
                No contact messages found.
            </div>
        @else

            <div class="space-y-4">
                @foreach($contacts as $contact)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-5 sm:p-6 border border-gray-100 dark:border-gray-700">

                        <!-- Top Info -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $contact->name }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $contact->email }}
                                </p>
                                @if($contact->phone)
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $contact->phone }}
                                    </p>
                                @endif
                            </div>

                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $contact->created_at->format('d M Y, h:i A') }}
                            </div>
                        </div>

                        <!-- Message -->
                        <div class="mt-4 p-4 rounded-lg bg-gray-50 dark:bg-gray-700/40 border border-gray-200 dark:border-gray-600">
                            <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">
                                {{ $contact->message }}
                            </p>
                        </div>

                        <!-- Actions -->
                        <div class="mt-4 flex justify-end">
                            <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button 
                                    onclick="return confirm('Are you sure you want to delete this message?')" 
                                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold text-sm transition">
                                    Delete Message
                                </button>
                            </form>
                        </div>

                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $contacts->links() }}
            </div>

        @endif

    </div>
</div>
@endsection