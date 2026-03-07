<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Product;
use App\Models\ProductSize;
use App\Support\AdminNotifier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StockAlertController extends Controller
{
    public function store(Request $request, Product $product): JsonResponse
    {
        $validated = $request->validate([
            'size' => 'required|string|in:xs,s,m,l,xl,xxl',
            'phone' => 'nullable|string|max:30',
        ]);

        $size = strtolower($validated['size']);

        $sizeRow = ProductSize::where('product_id', $product->id)
            ->where('size', $size)
            ->first();

        if (!$sizeRow) {
            return response()->json([
                'success' => false,
                'message' => 'This size is not configured for the selected product.',
            ], 422);
        }

        if ((int) $sizeRow->stock_quantity > 0) {
            return response()->json([
                'success' => false,
                'message' => 'This size is already back in stock.',
            ], 422);
        }

        $user = $request->user();
        $phone = trim((string) ($validated['phone'] ?? ''));
        $phone = $phone !== '' ? $phone : 'N/A';

        Contact::create([
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $phone,
            'message' => 'Stock alert request: Product "' . $product->name . '", size ' . strtoupper($size) . '. User wants to be notified when restocked.',
        ]);

        AdminNotifier::notifyAll(
            'Out of stock request',
            $user->name . ' requested restock notification for ' . $product->name . ' (' . strtoupper($size) . ').',
            'warning',
            route('admin.contacts.index'),
            'Open Requests',
            [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'size' => strtoupper($size),
                'user_id' => $user->id,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Request sent. Admin has been notified for size ' . strtoupper($size) . '.',
        ]);
    }
}
