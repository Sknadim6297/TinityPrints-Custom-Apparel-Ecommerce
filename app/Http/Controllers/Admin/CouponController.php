<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::orderBy('created_at', 'desc')->paginate(12);

        return view('admin.coupons.index', compact('coupons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code',
            'discount_type' => 'required|in:flat,percentage',
            'discount_value' => 'required|numeric|min:0.01',
            'usage_limit' => 'nullable|integer|min:1',
            'per_customer_usage_limit' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
            'min_order_value' => 'nullable|numeric|min:0',
            'customer_email' => 'nullable|email',
            'is_active' => 'boolean',
        ]);

        Coupon::create([
            'code' => strtoupper($validated['code']),
            'discount_type' => $validated['discount_type'],
            'discount_value' => $validated['discount_value'],
            'usage_limit' => $validated['usage_limit'] ?? null,
            'per_customer_usage_limit' => $validated['per_customer_usage_limit'] ?? null,
            'expires_at' => $validated['expires_at'] ?? null,
            'min_order_value' => $validated['min_order_value'] ?? null,
            'customer_email' => $validated['customer_email'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon created successfully.');
    }

    public function toggle(Request $request, Coupon $coupon)
    {
        $coupon->update([
            'is_active' => !$coupon->is_active,
        ]);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon status updated.');
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'discount_type' => 'required|in:flat,percentage',
            'discount_value' => 'required|numeric|min:0.01',
            'usage_limit' => 'nullable|integer|min:1',
            'per_customer_usage_limit' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
            'min_order_value' => 'nullable|numeric|min:0',
            'customer_email' => 'nullable|email',
            'is_active' => 'boolean',
        ]);

        $coupon->update([
            'code' => strtoupper($validated['code']),
            'discount_type' => $validated['discount_type'],
            'discount_value' => $validated['discount_value'],
            'usage_limit' => $validated['usage_limit'] ?? null,
            'per_customer_usage_limit' => $validated['per_customer_usage_limit'] ?? null,
            'expires_at' => $validated['expires_at'] ?? null,
            'min_order_value' => $validated['min_order_value'] ?? null,
            'customer_email' => $validated['customer_email'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon updated successfully.');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon deleted successfully.');
    }
}