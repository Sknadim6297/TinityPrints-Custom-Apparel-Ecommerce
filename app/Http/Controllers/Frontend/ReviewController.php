<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->back()->with('error', 'Please login to submit a review.');
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['is_approved'] = true; // Auto-approve, or set to false for manual approval

        try {
            ProductReview::updateOrCreate(
                [
                    'product_id' => $validated['product_id'],
                    'user_id' => $validated['user_id'],
                ],
                [
                    'rating' => $validated['rating'],
                    'comment' => $validated['comment'],
                    'is_approved' => $validated['is_approved'],
                ]
            );

            return redirect()->back()->with('success', 'Thank you for your review!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to submit review. Please try again.');
        }
    }
}
