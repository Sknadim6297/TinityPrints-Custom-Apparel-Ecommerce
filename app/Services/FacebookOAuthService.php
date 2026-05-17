<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FacebookOAuthService
{
    /**
     * Get the Facebook OAuth authorization URL
     */
    public function getAuthorizationUrl(string $state): string
    {
        $params = [
            'client_id' => config('oauth.facebook.client_id'),
            'redirect_uri' => $this->redirectUri(),
            'response_type' => 'code',
            'scope' => 'email,public_profile',
            'state' => $state,
        ];

        return 'https://www.facebook.com/v21.0/dialog/oauth?' . http_build_query($params);
    }

    public function redirectUri(): string
    {
        $configured = trim((string) config('oauth.facebook.redirect_uri'));

        if ($configured !== '') {
            return $configured;
        }

        return route('oauth.facebook.callback', absolute: true);
    }

    /**
     * Exchange authorization code for access token
     */
    public function getAccessToken(string $code): ?array
    {
        try {
            $response = Http::get('https://graph.facebook.com/v21.0/oauth/access_token', [
                'client_id' => config('oauth.facebook.client_id'),
                'client_secret' => config('oauth.facebook.client_secret'),
                'code' => $code,
                'redirect_uri' => $this->redirectUri(),
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['access_token'])) {
                    return $data;
                }
            }

            Log::error('Facebook token exchange failed', ['response' => $response->json()]);
            return null;
        } catch (Exception $e) {
            Log::error('Facebook OAuth error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get user information from Facebook using access token
     */
    public function getUserInfo(string $accessToken): ?array
    {
        try {
            $response = Http::get('https://graph.facebook.com/v21.0/me', [
                'fields' => 'id,name,email,picture.type(large)',
                'access_token' => $accessToken,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Facebook userinfo fetch failed', ['response' => $response->json()]);
            return null;
        } catch (Exception $e) {
            Log::error('Facebook userinfo error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Find or create user from Facebook OAuth data
     */
    public function findOrCreateUser(array $facebookUser): ?User
    {
        try {
            // First, try to find user by provider ID
            $user = User::where('provider_name', 'facebook')
                ->where('provider_id', $facebookUser['id'])
                ->first();

            if ($user) {
                // Update user info
                $this->updateUserInfo($user, $facebookUser);
                return $user;
            }

            // Check if email already exists
            $userEmail = $facebookUser['email'] ?? null;
            if ($userEmail) {
                $existingUser = User::where('email', $userEmail)->first();

                if ($existingUser) {
                    // Link social account to existing user
                    return $this->linkSocialAccount($existingUser, 'facebook', $facebookUser);
                }
            }

            // Create new user
            $user = User::create([
                'name' => $facebookUser['name'] ?? 'User',
                'email' => $userEmail ?? 'facebook_' . $facebookUser['id'] . '@local.app',
                'provider_name' => 'facebook',
                'provider_id' => $facebookUser['id'],
                'avatar' => $this->resolveAvatarUrl($facebookUser),
                'social_email' => $userEmail,
                'email_verified_at' => $userEmail ? now() : null,
                'password' => Str::password(32),
                'role' => 'customer',
            ]);

            Log::info('New user created via Facebook OAuth', ['user_id' => $user->id, 'email' => $user->email]);
            return $user;
        } catch (Exception $e) {
            Log::error('Error finding/creating user from Facebook data: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Update user information from OAuth provider
     */
    private function updateUserInfo(User $user, array $facebookUser): void
    {
        try {
            $updateData = [
                'social_email' => $facebookUser['email'] ?? $user->social_email,
            ];

            // Update avatar if available
            if ($avatar = $this->resolveAvatarUrl($facebookUser)) {
                $updateData['avatar'] = $avatar;
            }

            $user->update($updateData);
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
            $updateData = [
                'provider_name' => $provider,
                'provider_id' => $providerUser['id'],
                'social_email' => $providerUser['email'] ?? $user->social_email,
            ];

            if ($avatar = $this->resolveAvatarUrl($providerUser)) {
                $updateData['avatar'] = $avatar;
            }

            $user->update($updateData);

            Log::info('Social account linked', ['user_id' => $user->id, 'provider' => $provider]);
        } catch (Exception $e) {
            Log::error('Error linking social account: ' . $e->getMessage());
        }

        return $user;
    }

    /**
     * Validate OAuth configuration
     */
    public static function isConfigured(): bool
    {
        return !empty(config('oauth.facebook.client_id'))
            && !empty(config('oauth.facebook.client_secret'));
    }

    private function resolveAvatarUrl(array $facebookUser): ?string
    {
        $picture = $facebookUser['picture'] ?? null;

        if (is_string($picture)) {
            return $picture;
        }

        if (is_array($picture)) {
            return $picture['data']['url'] ?? $picture['url'] ?? null;
        }

        return null;
    }
}
