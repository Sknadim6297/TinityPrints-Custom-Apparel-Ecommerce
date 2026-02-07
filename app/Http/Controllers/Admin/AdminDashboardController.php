<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RefundRequest;
use Illuminate\Http\Request;
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
        // TODO: Replace with actual data from your models
        return [
            'total_orders' => 0,
            'pending_design_approvals' => 0,
            'pending_payments' => 0,
            'orders_in_printing' => 0,
            'shipped_orders' => 0,
            'refund_requests' => Schema::hasTable('refund_requests')
                ? RefundRequest::where('status', 'requested')->count()
                : 0,
            'monthly_sales' => 0,
            'active_limited_editions' => 0,
            'monthly_chart_data' => $this->getMonthlySalesData(),
        ];
    }

    /**
     * Get monthly sales data for chart
     */
    private function getMonthlySalesData(): array
    {
        // TODO: Replace with actual data
        return [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'data' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        ];
    }
}
