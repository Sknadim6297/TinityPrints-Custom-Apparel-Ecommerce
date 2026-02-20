<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoginHistory;
use Illuminate\Http\Request;

class AdminLoginHistoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $query = LoginHistory::with('user')
            ->orderByDesc('login_time');

        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhere('ip_address', 'like', "%{$search}%");
        }

        $histories = $query->paginate(25)->withQueryString();

        return view('admin.login-history.index', compact('histories', 'search'));
    }
}
