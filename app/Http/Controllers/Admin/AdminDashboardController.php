<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DesignRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\RefundRequest;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): View
    {
        $stats = $this->getDashboardStats();
        
        return view('admin.admin-dashboard', compact('stats'));
    }

    /**
     * Get dashboard statistics
     */
    private function getDashboardStats(): array
    {
        $ordersTableExists = Schema::hasTable('orders');
        $designRequestsTableExists = Schema::hasTable('design_requests');
        $productsTableExists = Schema::hasTable('products');
        $refundRequestsTableExists = Schema::hasTable('refund_requests');

        $now = now();
        $startOfMonth = $now->copy()->startOfMonth();

        return [
            'total_orders' => $ordersTableExists ? Order::count() : 0,
            'pending_design_approvals' => $designRequestsTableExists
                ? DesignRequest::where('status', 'pending')->count()
                : 0,
            'pending_payments' => $ordersTableExists
                ? Order::whereIn('payment_status', ['pending', 'unpaid'])->count()
                : 0,
            'orders_in_printing' => $ordersTableExists
                ? Order::where('order_status', 'printing')->count()
                : 0,
            'shipped_orders' => $ordersTableExists
                ? Order::where('order_status', 'shipped')->count()
                : 0,
            'refund_requests' => $refundRequestsTableExists
                ? RefundRequest::whereIn('status', ['refund_requested', 'under_review', 'pending_customer_response'])->count()
                : 0,
            'monthly_sales' => $ordersTableExists
                ? (float) Order::where('payment_status', 'paid')
                    ->where('created_at', '>=', $startOfMonth)
                    ->sum('total_amount')
                : 0,
            'active_limited_editions' => $productsTableExists
                ? Product::query()
                    ->where('is_limited_edition', true)
                    ->where('is_active', true)
                    ->where(function ($query) use ($now) {
                        $query->whereNull('drop_start_at')->orWhere('drop_start_at', '<=', $now);
                    })
                    ->where(function ($query) use ($now) {
                        $query->whereNull('drop_end_at')->orWhere('drop_end_at', '>=', $now);
                    })
                    ->count()
                : 0,
            'monthly_chart_data' => $this->getMonthlySalesData(),
        ];
    }

    /**
     * Get monthly sales data for chart
     */
    private function getMonthlySalesData(): array
    {
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        if (!Schema::hasTable('orders')) {
            return [
                'labels' => $labels,
                'data' => array_fill(0, 12, 0),
            ];
        }

        $year = now()->year;

        $monthlySales = Order::query()
            ->selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
            ->where('payment_status', 'paid')
            ->whereYear('created_at', $year)
            ->groupByRaw('MONTH(created_at)')
            ->pluck('total', 'month');

        $data = [];
        for ($month = 1; $month <= 12; $month++) {
            $data[] = (float) ($monthlySales[$month] ?? 0);
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }
}
