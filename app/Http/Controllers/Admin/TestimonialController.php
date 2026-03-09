<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('sort_order')->paginate(10);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'author_name' => 'required|string|max:255',
            'author_desc' => 'nullable|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:5120',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $testimonial = new Testimonial();
        $testimonial->author_name = $validated['author_name'];
        $testimonial->author_desc = $validated['author_desc'] ?? null;
        $testimonial->content = $validated['content'];
        $testimonial->is_active = $validated['is_active'] ?? false;
        $testimonial->sort_order = $validated['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            $testimonial->image_path = $request->file('image')->store('testimonials', 'public');
        }

        $testimonial->save();

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial created successfully.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'author_name' => 'required|string|max:255',
            'author_desc' => 'nullable|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:5120',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $testimonial->author_name = $validated['author_name'];
        $testimonial->author_desc = $validated['author_desc'] ?? null;
        $testimonial->content = $validated['content'];
        $testimonial->is_active = $validated['is_active'] ?? false;
        $testimonial->sort_order = $validated['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            // delete old if exists
            if ($testimonial->image_path) {
                Storage::disk('public')->delete($testimonial->image_path);
            }
            $testimonial->image_path = $request->file('image')->store('testimonials', 'public');
        }

        $testimonial->save();

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial updated successfully.');
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->image_path) {
            Storage::disk('public')->delete($testimonial->image_path);
        }
        $testimonial->delete();
        return back()->with('success', 'Testimonial deleted successfully.');
    }
}
