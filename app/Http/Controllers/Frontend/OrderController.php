<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with(['items.product.images'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('frontend.orders', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['items.product.images'])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('frontend.order-details', compact('order'));
    }
}
