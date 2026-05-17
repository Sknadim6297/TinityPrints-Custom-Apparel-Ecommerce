<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\LoginHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(Request $request): View
    {
        $this->rememberIntendedUrl($request);

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

        // Explicit redirect from login form has priority if valid.
        $redirectTo = $request->input('redirect_to');

        if ($redirectTo && $this->isValidInternalUrl($redirectTo)) {
            $request->session()->put('url.intended', $redirectTo);
        }

        return redirect()->intended($this->redirectPath($request->user()));
    }

    /**
     * Store intended URL when user opens login directly from a protected context.
     */
    private function rememberIntendedUrl(Request $request): void
    {
        $candidate = $request->query('redirect_to') ?: url()->previous();

        if (! $this->isValidInternalUrl($candidate)) {
            return;
        }

        $path = parse_url($candidate, PHP_URL_PATH) ?? '';

        // Avoid loops back to auth endpoints.
        $blockedPaths = ['/login', '/auth/login', '/register', '/auth/register', '/forgot-password', '/auth/forgot-password', '/logout', '/auth/logout'];
        foreach ($blockedPaths as $blockedPath) {
            if (Str::startsWith($path, $blockedPath)) {
                return;
            }
        }

        $request->session()->put('url.intended', $candidate);
    }

    /**
     * Validate that the redirect URL is internal (not an open redirect).
     */
    private function isValidInternalUrl(?string $url): bool
    {
        if (!$url) {
            return false;
        }

        // Parse the URL
        $parsed = parse_url($url);
        
        // Allow only relative URLs or URLs with the same host
        if (isset($parsed['host'])) {
            return $parsed['host'] === request()->getHost();
        }

        // Allow relative URLs starting with /
        return strpos($url, '/') === 0;
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

        return redirect()->route('login');
    }

    private function redirectPath($user): string
    {
        if ($user && $user->role === 'admin') {
            return '/admin/dashboard';
        }

        return '/';
    }
}
