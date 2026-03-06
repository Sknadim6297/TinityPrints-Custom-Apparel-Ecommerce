<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\DesignRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CustomDesignController extends Controller
{
    /**
     * Show the custom design form
     */
    public function create()
    {
        $userDesigns = null;
        if (Auth::check()) {
            $userDesigns = DesignRequest::where('user_id', Auth::id())
                ->latest()
                ->get();
        }

        return view('frontend.custom-design', [
            'userDesigns' => $userDesigns
        ]);
    }

    /**
     * Store custom design submission
     */
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'selected_size' => 'required|in:m,l,xl',
            'sleeve_type' => 'required|in:full,half',
            'color' => 'required|string',
            'front_design_file' => 'required|file|mimes:png,jpg,jpeg,pdf|max:10240',
            'back_design_file' => 'nullable|file|mimes:png,jpg,jpeg,pdf|max:10240',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            // Upload front design file
            $frontPath = null;
            if ($request->hasFile('front_design_file')) {
                $frontPath = $request->file('front_design_file')->store('designs/front', 'public');
            }

            // Upload back design file if provided
            $backPath = null;
            if ($request->hasFile('back_design_file')) {
                $backPath = $request->file('back_design_file')->store('designs/back', 'public');
            }

            // Create design request
            $design = DesignRequest::create([
                'user_id' => Auth::id(),
                'customer_name' => $validated['customer_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'selected_size' => $validated['selected_size'],
                'sleeve_type' => $validated['sleeve_type'],
                'color' => $validated['color'],
                'front_design_file' => $frontPath,
                'back_design_file' => $backPath,
                'notes' => $validated['notes'] ?? null,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'payment_unlocked' => false,
            ]);
            return redirect()->route('custom-design.show', $design)
                ->with('success', 'Your design has been submitted for review! Our team will review it within 24-48 hours.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error uploading design. Please try again.')
                ->withInput();
        }
    }


    /**
     * Show custom design details
     */
    public function show(DesignRequest $design)
    {
        // Check if user owns this design
        if ($design->user_id !== Auth::id() && !Auth::guard('admin')->check()) {
            abort(403, 'Unauthorized access');
        }

        return view('frontend.custom-design-detail', [
            'design' => $design
        ]);
    }

    /**
     * Resubmit design after revision request
     */
    public function update(Request $request, DesignRequest $design)
    {
        // Check ownership
        if ($design->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Check if revision is requested
        if ($design->status !== 'changes_requested') {
            return back()->with('error', 'This design does not require revision.');
        }

        // Validate input
        $validated = $request->validate([
            'front_design_file' => 'nullable|file|mimes:png,jpg,jpeg,pdf|max:10240',
            'back_design_file' => 'nullable|file|mimes:png,jpg,jpeg,pdf|max:10240',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            // Delete old files if new ones are uploaded
            if ($request->hasFile('front_design_file')) {
                if ($design->front_design_file) {
                    Storage::disk('public')->delete($design->front_design_file);
                }
                $design->front_design_file = $request->file('front_design_file')
                    ->store('designs/front', 'public');
            }

            if ($request->hasFile('back_design_file')) {
                if ($design->back_design_file) {
                    Storage::disk('public')->delete($design->back_design_file);
                }
                $design->back_design_file = $request->file('back_design_file')
                    ->store('designs/back', 'public');
            }

            // Update notes if provided
            if (isset($validated['notes'])) {
                $design->notes = $validated['notes'];
            }

            // Reset design to pending status
            $design->status = 'pending';
            $design->admin_remark = null;
            $design->reviewed_by = null;
            $design->reviewed_at = null;
            $design->save();

            return back()->with('success', 'Your revised design has been resubmitted for review!');

        } catch (\Exception $e) {
            return back()->with('error', 'Error uploading files. Please try again.');
        }
    }

    /**
     * Download design file (for admin or owner)
     */
    public function download(Request $request, DesignRequest $design, $fileType)
    {
        // Check authorization
        if ($design->user_id !== Auth::id() && !Auth::guard('admin')->check()) {
            abort(403, 'Unauthorized');
        }

        if ($fileType === 'front' && $design->front_design_file) {
            return Storage::disk('public')->download($design->front_design_file);
        } elseif ($fileType === 'back' && $design->back_design_file) {
            return Storage::disk('public')->download($design->back_design_file);
        }

        return back()->with('error', 'File not found.');
    }

    /**
     * Initiate payment for approved design
     */
    public function initiatePayment(DesignRequest $design)
    {
        // Check ownership
        if ($design->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Check if design is approved and payment is unlocked
        if (!$design->canPay()) {
            return back()->with('error', 'This design is not ready for payment yet.');
        }

        // Check if price is set
        if (!$design->price || $design->price <= 0) {
            return back()->with('error', 'Price has not been set for this design.');
        }

        // Store design ID in session for checkout
        session([
            'custom_design_checkout' => $design->id,
            'checkout_type' => 'custom_design'
        ]);

        return redirect()->route('custom-design.checkout', $design);
    }

    /**
     * Show checkout page for custom design
     */
    public function checkout(DesignRequest $design)
    {
        // Check ownership
        if ($design->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Check if design is approved and payment is unlocked
        if (!$design->canPay()) {
            return back()->with('error', 'This design is not ready for payment yet.');
        }

        return view('frontend.custom-design-checkout', [
            'design' => $design,
            'user' => Auth::user()
        ]);
    }

    /**
     * Process payment for custom design
     */
    public function processPayment(Request $request, DesignRequest $design)
    {
        // Check ownership
        if ($design->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Check if design is approved and ready for payment
        if (!$design->canPay()) {
            return back()->with('error', 'This design is not ready for payment.');
        }

        $validated = $request->validate([
            'payment_method' => 'required|in:cod,online',
            'shipping_address' => 'required|string|max:500',
            'shipping_city' => 'required|string|max:100',
            'shipping_state' => 'required|string|max:100',
            'shipping_postal_code' => 'required|string|max:20',
            'shipping_country' => 'required|string|max:100',
        ]);

        try {
            // Create order from the design
            $order = \App\Models\Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'customer_name' => $design->customer_name,
                'email' => $design->email,
                'phone' => $design->phone,
                'product_name' => 'Custom Design T-Shirt #' . $design->id,
                'product_size' => strtoupper($design->selected_size),
                'quantity' => 1,
                'shipping_address' => $validated['shipping_address'],
                'shipping_city' => $validated['shipping_city'],
                'shipping_state' => $validated['shipping_state'],
                'shipping_postal_code' => $validated['shipping_postal_code'],
                'shipping_country' => $validated['shipping_country'],
                'subtotal' => $design->price,
                'total_amount' => $design->price,
                'payment_method' => $validated['payment_method'],
                'payment_status' => $validated['payment_method'] === 'cod' ? 'pending' : 'paid',
                'order_status' => $validated['payment_method'] === 'cod' ? 'payment_pending' : 'paid',
                'design_request_id' => $design->id,
                'custom_design_status' => 'approved',
            ]);

            // Create order item for the custom design
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => null, // Custom design, no product
                'product_name' => 'Custom Design T-Shirt #' . $design->id,
                'size' => strtoupper($design->selected_size),
                'color_name' => $design->color,
                'quantity' => 1,
                'price' => $design->price,
                'total' => $design->price,
            ]);

            // Update design with order reference
            $design->update([
                'order_id' => $order->id,
                'payment_status' => $validated['payment_method'] === 'cod' ? 'unpaid' : 'paid',
            ]);

            // Clear session
            session()->forget(['custom_design_checkout', 'checkout_type']);

            return redirect()->route('order.success', $order)
                ->with('success', 'Your order has been placed successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Error processing payment. Please try again.');
        }
    }
}