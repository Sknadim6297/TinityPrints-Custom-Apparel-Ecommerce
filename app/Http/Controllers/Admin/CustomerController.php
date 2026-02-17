<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoginHistory;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    public function index(): JsonResponse
    {
        $customers = User::query()
            ->where('role', 'customer')
            ->withCount('loginHistories')
            ->withMax('loginHistories', 'login_time')
            ->orderByDesc('created_at')
            ->get()
            ->map(function (User $user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'registered_at' => $user->created_at,
                    'total_logins' => $user->login_histories_count,
                    'last_login' => $user->login_histories_max_login_time,
                    'history_url' => route('admin.customers.history', $user->id),
                ];
            });

        return response()->json(['data' => $customers]);
    }

    public function history(int $id): JsonResponse
    {
        $user = User::query()->findOrFail($id);

        $histories = LoginHistory::query()
            ->where('user_id', $user->id)
            ->latest('login_time')
            ->get()
            ->map(function (LoginHistory $history) {
                $durationSeconds = null;

                if ($history->login_time && $history->logout_time) {
                    $durationSeconds = $history->logout_time->diffInSeconds($history->login_time);
                }

                return [
                    'login_time' => $history->login_time,
                    'logout_time' => $history->logout_time,
                    'ip_address' => $history->ip_address,
                    'device' => $history->device,
                    'session_duration_seconds' => $durationSeconds,
                ];
            });

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
            ],
            'data' => $histories,
        ]);
    }
}
