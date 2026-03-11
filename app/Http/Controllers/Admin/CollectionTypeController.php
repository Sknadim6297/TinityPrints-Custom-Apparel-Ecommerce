<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CollectionType;
use Illuminate\Http\Request;

class CollectionTypeController extends Controller
{
    public function index(Request $request)
    {
        $query = CollectionType::query();

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->boolean('status'));
        }

        $collectionTypes = $query->with('admin')->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('admin.collection-types.index', compact('collectionTypes'));
    }

    public function create()
    {
        return view('admin.collection-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:collection_types,name',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ]);

        $validated['created_by'] = auth()->guard('admin')->id();

        CollectionType::create($validated);

        return redirect()->route('admin.collection-types.index')
            ->with('success', 'Collection Type created successfully!');
    }

    public function edit(CollectionType $collectionType)
    {
        return view('admin.collection-types.edit', compact('collectionType'));
    }

    public function update(Request $request, CollectionType $collectionType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:collection_types,name,' . $collectionType->id,
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ]);

        $collectionType->update($validated);

        return redirect()->route('admin.collection-types.index')
            ->with('success', 'Collection Type updated successfully!');
    }

    public function destroy(CollectionType $collectionType)
    {
        // Check if collection type is used by any products
        if ($collectionType->products()->exists()) {
            return back()->with('error', 'Cannot delete collection type that has products assigned.');
        }

        $collectionType->delete();

        return redirect()->route('admin.collection-types.index')
            ->with('success', 'Collection Type deleted successfully!');
    }

    public function toggle(CollectionType $collectionType)
    {
        $collectionType->update(['is_active' => !$collectionType->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $collectionType->is_active,
            'message' => 'Collection Type status updated successfully!'
        ]);
    }
}
