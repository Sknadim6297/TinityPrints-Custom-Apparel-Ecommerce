<?php

namespace App\Helpers;

/**
 * OAuth Helper Functions and Constants
 * 
 * This helper provides utility functions and constants for OAuth implementation
 */

class OAuthHelper
{
    /**
     * OAuth Provider Constants
     */
    const PROVIDER_GOOGLE = 'google';
    const PROVIDER_FACEBOOK = 'facebook';
    
    /**
     * Supported OAuth Providers
     */
    const SUPPORTED_PROVIDERS = [
        self::PROVIDER_GOOGLE,
        self::PROVIDER_FACEBOOK,
    ];
    
    /**
     * OAuth Scopes
     */
    const GOOGLE_SCOPES = [
        'openid',
        'email',
        'profile',
    ];
    
    const FACEBOOK_SCOPES = [
        'email',
        'public_profile',
    ];
    
    /**
     * Check if OAuth provider is configured
     * 
     * @param string $provider Provider name (google, facebook)
     * @return bool
     */
    public static function isProviderConfigured(string $provider): bool
    {
        switch ($provider) {
            case self::PROVIDER_GOOGLE:
                return !empty(config('oauth.google.client_id')) 
                    && !empty(config('oauth.google.client_secret'));
                    
            case self::PROVIDER_FACEBOOK:
                return !empty(config('oauth.facebook.client_id')) 
                    && !empty(config('oauth.facebook.client_secret'));
                    
            default:
                return false;
        }
    }
    
    /**
     * Check if any OAuth provider is configured
     * 
     * @return bool
     */
    public static function isAnyProviderConfigured(): bool
    {
        foreach (self::SUPPORTED_PROVIDERS as $provider) {
            if (self::isProviderConfigured($provider)) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Get configured providers
     * 
     * @return array List of configured provider names
     */
    public static function getConfiguredProviders(): array
    {
        $configured = [];
        
        foreach (self::SUPPORTED_PROVIDERS as $provider) {
            if (self::isProviderConfigured($provider)) {
                $configured[] = $provider;
            }
        }
        
        return $configured;
    }
    
    /**
     * Get provider display name
     * 
     * @param string $provider Provider name
     * @return string Display name
     */
    public static function getProviderDisplayName(string $provider): string
    {
        $names = [
            self::PROVIDER_GOOGLE => 'Google',
            self::PROVIDER_FACEBOOK => 'Facebook',
        ];
        
        return $names[$provider] ?? ucfirst($provider);
    }
    
    /**
     * Get provider icon/SVG
     * 
     * @param string $provider Provider name
     * @return string SVG or HTML
     */
    public static function getProviderIcon(string $provider): string
    {
        $icons = [
            self::PROVIDER_GOOGLE => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>',
            self::PROVIDER_FACEBOOK => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><path fill="#2467ec" d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
        ];
        
        return $icons[$provider] ?? '';
    }
    
    /**
     * Generate OAuth state token
     * 
     * @return string Random state token
     */
    public static function generateStateToken(): string
    {
        return \Illuminate\Support\Str::random(40);
    }
    
    /**
     * Get OAuth redirect URL for provider
     * 
     * @param string $provider Provider name
     * @return string|null Route URL or null if not configured
     */
    public static function getOAuthRedirectUrl(string $provider): ?string
    {
        if (!self::isProviderConfigured($provider)) {
            return null;
        }
        
        return route("oauth.{$provider}");
    }
    
    /**
     * Check if email is from OAuth provider
     * 
     * @param string $email Email to check
     * @param string $provider Provider name
     * @return bool
     */
    public static function isOAuthEmail(string $email, string $provider): bool
    {
        $patterns = [
            self::PROVIDER_GOOGLE => '/@gmail\.com$|@googlemail\.com$/',
            self::PROVIDER_FACEBOOK => '/@local\.app$/', // Local OAuth emails
        ];
        
        return isset($patterns[$provider]) && preg_match($patterns[$provider], $email);
    }
    
    /**
     * Generate local email for user without OAuth email
     * 
     * @param string $provider Provider name
     * @param string $providerId Provider user ID
     * @return string Local email
     */
    public static function generateLocalEmail(string $provider, string $providerId): string
    {
        return "{$provider}_{$providerId}@local.app";
    }
    
    /**
     * Log OAuth event
     * 
     * @param string $event Event name
     * @param string $provider Provider name
     * @param array $data Additional data
     * @return void
     */
    public static function logEvent(string $event, string $provider, array $data = []): void
    {
        $context = array_merge(['provider' => $provider], $data);
        \Illuminate\Support\Facades\Log::info("OAuth {$event}", $context);
    }
    
    /**
     * Log OAuth error
     * 
     * @param string $message Error message
     * @param string $provider Provider name
     * @param array $details Error details
     * @return void
     */
    public static function logError(string $message, string $provider, array $details = []): void
    {
        $context = array_merge(['provider' => $provider, 'details' => $details], $details);
        \Illuminate\Support\Facades\Log::error("OAuth: {$message}", $context);
    }
    
    /**
     * Validate OAuth response data
     * 
     * @param array $data OAuth response data
     * @param string $provider Provider name
     * @return bool
     */
    public static function validateOAuthData(array $data, string $provider): bool
    {
        switch ($provider) {
            case self::PROVIDER_GOOGLE:
                return isset($data['sub']) && isset($data['email']);
                
            case self::PROVIDER_FACEBOOK:
                return isset($data['id']);
                
            default:
                return false;
        }
    }
    
    /**
     * Extract user data from OAuth response
     * 
     * @param array $data OAuth response data
     * @param string $provider Provider name
     * @return array|null Extracted user data or null if invalid
     */
    public static function extractUserData(array $data, string $provider): ?array
    {
        if (!self::validateOAuthData($data, $provider)) {
            return null;
        }
        
        switch ($provider) {
            case self::PROVIDER_GOOGLE:
                return [
                    'provider_id' => $data['sub'],
                    'name' => $data['name'] ?? 'User',
                    'email' => $data['email'],
                    'avatar' => $data['picture'] ?? null,
                    'email_verified' => true,
                ];
                
            case self::PROVIDER_FACEBOOK:
                return [
                    'provider_id' => $data['id'],
                    'name' => $data['name'] ?? 'User',
                    'email' => $data['email'] ?? null,
                    'avatar' => $data['picture']['data']['url'] ?? null,
                    'email_verified' => !empty($data['email']),
                ];
                
            default:
                return null;
        }
    }
    
    /**
     * Check if user has OAuth provider linked
     * 
     * @param \App\Models\User $user
     * @param string $provider Provider name
     * @return bool
     */
    public static function userHasOAuthProvider($user, string $provider): bool
    {
        return $user->provider_name === $provider && !empty($user->provider_id);
    }
    
    /**
     * Check if user has any OAuth provider linked
     * 
     * @param \App\Models\User $user
     * @return bool
     */
    public static function userHasAnyOAuthProvider($user): bool
    {
        return !empty($user->provider_name) && !empty($user->provider_id);
    }
    
    /**
     * Get OAuth provider for user
     * 
     * @param \App\Models\User $user
     * @return string|null Provider name or null
     */
    public static function getUserOAuthProvider($user): ?string
    {
        return $user->provider_name ?? null;
    }
    
    /**
     * Format OAuth error message for user
     * 
     * @param string $error Technical error
     * @param string $provider Provider name
     * @return string User-friendly error message
     */
    public static function formatErrorMessage(string $error, string $provider): string
    {
        $messages = [
            'access_denied' => "You denied access to {provider}. Please try again.",
            'invalid_scope' => "{provider} doesn't support the requested permissions.",
            'invalid_request' => "Invalid request to {provider}. Please try again.",
            'invalid_client' => "{provider} credentials are not configured correctly.",
            'temporary_error' => "{provider} is temporarily unavailable. Please try again later.",
        ];
        
        $providerName = self::getProviderDisplayName($provider);
        $message = $messages[$error] ?? "Unable to login with {provider}. Please try again.";
        
        return str_replace('{provider}', $providerName, $message);
    }
}
