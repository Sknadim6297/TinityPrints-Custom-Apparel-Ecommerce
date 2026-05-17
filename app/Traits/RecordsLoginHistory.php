<?php

namespace App\Traits;

use App\Models\LoginHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

trait RecordsLoginHistory
{
    protected function recordLoginHistory(Request $request): void
    {
        $loginHistory = LoginHistory::create([
            'user_id' => $request->user()->id,
            'ip_address' => $request->ip(),
            'login_time' => Date::now(),
            'device' => $request->userAgent(),
        ]);

        $request->session()->put('login_history_id', $loginHistory->id);
    }
}
