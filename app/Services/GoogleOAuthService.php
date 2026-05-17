<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GoogleOAuthService
{
    /**
     * Get the Google OAuth authorization URL
     */
    public function getAuthorizationUrl(string $state): string
    {
        $params = [
            'client_id' => config('oauth.google.client_id'),
            'redirect_uri' => $this->redirectUri(),
            'response_type' => 'code',
            'scope' => 'openid email profile',
            'state' => $state,
            'access_type' => 'offline',
            'prompt' => 'consent',
        ];

        return 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params);
    }

    /**
     * Exchange authorization code for access token
     */
    public function getAccessToken(string $code): ?array
    {
        try {
            $response = Http::post('https://oauth2.googleapis.com/token', [
                'client_id' => config('oauth.google.client_id'),
                'client_secret' => config('oauth.google.client_secret'),
                'code' => $code,
                'grant_type' => 'authorization_code',
                'redirect_uri' => $this->redirectUri(),
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Google token exchange failed', ['response' => $response->json()]);
            return null;
        } catch (Exception $e) {
            Log::error('Google OAuth error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get user information from Google using access token
     */
    public function getUserInfo(string $accessToken): ?array
    {
        try {
            $response = Http::withToken($accessToken)
                ->get('https://openidconnect.googleapis.com/v1/userinfo');

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Google userinfo fetch failed', ['response' => $response->json()]);
            return null;
        } catch (Exception $e) {
            Log::error('Google userinfo error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Find or create user from Google OAuth data
     */
    public function findOrCreateUser(array $googleUser): ?User
    {
        try {
            // First, try to find user by provider ID
            $user = User::where('provider_name', 'google')
                ->where('provider_id', $googleUser['sub'])
                ->first();

            if ($user) {
                // Update user info
                $this->updateUserInfo($user, $googleUser);
                return $user;
            }

            // Check if email already exists
            $existingUser = User::where('email', $googleUser['email'])->first();

            if ($existingUser) {
                // Link social account to existing user
                return $this->linkSocialAccount($existingUser, 'google', $googleUser);
            }

            // Create new user
            $user = User::create([
                'name' => $googleUser['name'] ?? 'User',
                'email' => $googleUser['email'],
                'provider_name' => 'google',
                'provider_id' => $googleUser['sub'],
                'avatar' => $googleUser['picture'] ?? null,
                'social_email' => $googleUser['email'],
                'email_verified_at' => now(),
                'password' => Str::password(32),
                'role' => 'customer',
            ]);

            Log::info('New user created via Google OAuth', ['user_id' => $user->id, 'email' => $user->email]);
            return $user;
        } catch (Exception $e) {
            Log::error('Error finding/creating user from Google data: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Update user information from OAuth provider
     */
    private function updateUserInfo(User $user, array $googleUser): void
    {
        try {
            $user->update([
                'avatar' => $googleUser['picture'] ?? $user->avatar,
                'social_email' => $googleUser['email'],
            ]);
        } catch (Exception $e) {
            Log::error('Error updating user info: ' . $e->getMessage());
        }
    }

    /**
     * Link social account to existing user
     */
    private function linkSocialAccount(User $user, string $provider, array $providerUser): User
    {
        try {
            $user->update([
                'provider_name' => $provider,
                'provider_id' => $providerUser['sub'],
                'avatar' => $providerUser['picture'] ?? $user->avatar,
                'social_email' => $providerUser['email'],
            ]);

            Log::info('Social account linked', ['user_id' => $user->id, 'provider' => $provider]);
        } catch (Exception $e) {
            Log::error('Error linking social account: ' . $e->getMessage());
        }

        return $user;
    }

    /**
     * Validate OAuth configuration
     */
    public function redirectUri(): string
    {
        $configured = trim((string) config('oauth.google.redirect_uri'));

        if ($configured !== '') {
            return $configured;
        }

        return route('oauth.google.callback', absolute: true);
    }

    public static function isConfigured(): bool
    {
        return !empty(config('oauth.google.client_id'))
            && !empty(config('oauth.google.client_secret'));
    }
}
