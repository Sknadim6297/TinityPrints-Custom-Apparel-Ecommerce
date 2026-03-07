<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request): View
    {
        $this->rememberIntendedUrl($request);

        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'customer',
        ]);

        event(new Registered($user));

        Auth::login($user);

        $redirectTo = $request->input('redirect_to');
        if ($redirectTo && $this->isValidInternalUrl($redirectTo)) {
            $request->session()->put('url.intended', $redirectTo);
        }

        return redirect()->intended($this->redirectPath($user));
    }

    private function rememberIntendedUrl(Request $request): void
    {
        $candidate = $request->query('redirect_to') ?: url()->previous();

        if (! $this->isValidInternalUrl($candidate)) {
            return;
        }

        $path = parse_url($candidate, PHP_URL_PATH) ?? '';
        $blockedPaths = ['/login', '/register', '/forgot-password', '/logout'];

        foreach ($blockedPaths as $blockedPath) {
            if (Str::startsWith($path, $blockedPath)) {
                return;
            }
        }

        $request->session()->put('url.intended', $candidate);
    }

    private function isValidInternalUrl(?string $url): bool
    {
        if (!$url) {
            return false;
        }

        $parsed = parse_url($url);
        if (isset($parsed['host'])) {
            return $parsed['host'] === request()->getHost();
        }

        return strpos($url, '/') === 0;
    }

    private function redirectPath(User $user): string
    {
        if ($user->role === 'admin') {
            return '/admin/dashboard';
        }

        return '/';
    }
}
