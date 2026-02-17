<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\LoginHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $loginHistory = LoginHistory::create([
            'user_id' => $request->user()->id,
            'ip_address' => $request->ip(),
            'login_time' => Date::now(),
            'device' => $request->userAgent(),
        ]);

        $request->session()->put('login_history_id', $loginHistory->id);

        return redirect()->intended($this->redirectPath($request->user()));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $loginHistoryId = $request->session()->get('login_history_id');

        if ($loginHistoryId) {
            LoginHistory::where('id', $loginHistoryId)
                ->where('user_id', optional($request->user())->id)
                ->update(['logout_time' => Date::now()]);
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    private function redirectPath($user): string
    {
        if ($user && $user->role === 'admin') {
            return '/admin/dashboard';
        }

        return '/';
    }
}
