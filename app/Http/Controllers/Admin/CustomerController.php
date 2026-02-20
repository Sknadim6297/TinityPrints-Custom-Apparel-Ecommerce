<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoginHistory;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers.
     */
    public function index()
    {
        $search = request('search');
        $customers = User::where('role', 'customer');

        if ($search) {
            $customers->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $customers = $customers
            ->latest('created_at')
            ->paginate(15);

        return view('admin.customers.index', compact('customers', 'search'));
    }

    /**
     * Show the form for creating a new customer.
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Store a newly created customer in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $validated['role'] = 'customer';
        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer created successfully.');
    }

    /**
     * Display the specified customer.
     */
    public function show(User $customer)
    {
        if ($customer->role !== 'customer') {
            abort(404);
        }

        $reviews = $customer->reviews()->latest()->take(5)->get();
        $loginHistory = LoginHistory::where('user_id', $customer->id)
            ->latest('login_time')
            ->take(5)
            ->get();

        return view('admin.customers.show', compact('customer', 'reviews', 'loginHistory'));
    }

    /**
     * Show the form for editing the customer.
     */
    public function edit(User $customer)
    {
        if ($customer->role !== 'customer') {
            abort(404);
        }

        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified customer in storage.
     */
    public function update(Request $request, User $customer)
    {
        if ($customer->role !== 'customer') {
            abort(404);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $customer->id],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $customer->update($validated);

        return redirect()->route('admin.customers.show', $customer)
            ->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified customer from storage.
     */
    public function destroy(User $customer)
    {
        if ($customer->role !== 'customer') {
            abort(404);
        }

        $name = $customer->name;

        // Delete related data before deleting customer
        $customer->orders()->delete();
        $customer->wishlists()->delete();
        $customer->carts()->delete();
        $customer->reviews()->delete();
        LoginHistory::where('user_id', $customer->id)->delete();

        $customer->delete();

        return redirect()->route('admin.customers.index')
            ->with('success', "Customer '{$name}' deleted successfully.");
    }

    /**
     * Display customer login history.
     */
    public function history(User $customer)
    {
        if ($customer->role !== 'customer') {
            abort(404);
        }

        $loginHistory = LoginHistory::where('user_id', $customer->id)
            ->latest('login_time')
            ->paginate(20);

        return view('admin.customers.history', compact('customer', 'loginHistory'));
    }
}
