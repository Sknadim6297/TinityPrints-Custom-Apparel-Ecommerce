<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SleeveType;
use Illuminate\Http\Request;

class SleeveTypeController extends Controller
{
    public function index(Request $request)
    {
        $query = SleeveType::query();

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

        $sleeveTypes = $query->with('admin')->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('admin.sleeve-types.index', compact('sleeveTypes'));
    }

    public function create()
    {
        return view('admin.sleeve-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:sleeve_types,name',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ]);

        $validated['created_by'] = auth()->guard('admin')->id();

        SleeveType::create($validated);

        return redirect()->route('admin.sleeve-types.index')
            ->with('success', 'Sleeve Type created successfully!');
    }

    public function edit(SleeveType $sleeveType)
    {
        return view('admin.sleeve-types.edit', compact('sleeveType'));
    }

    public function update(Request $request, SleeveType $sleeveType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:sleeve_types,name,' . $sleeveType->id,
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ]);

        $sleeveType->update($validated);

        return redirect()->route('admin.sleeve-types.index')
            ->with('success', 'Sleeve Type updated successfully!');
    }

    public function destroy(SleeveType $sleeveType)
    {
        // Check if sleeve type is used by any products
        if ($sleeveType->products()->exists()) {
            return back()->with('error', 'Cannot delete sleeve type that has products assigned.');
        }

        $sleeveType->delete();

        return redirect()->route('admin.sleeve-types.index')
            ->with('success', 'Sleeve Type deleted successfully!');
    }

    public function toggle(SleeveType $sleeveType)
    {
        $sleeveType->update(['is_active' => !$sleeveType->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $sleeveType->is_active,
            'message' => 'Sleeve Type status updated successfully!'
        ]);
    }
}
