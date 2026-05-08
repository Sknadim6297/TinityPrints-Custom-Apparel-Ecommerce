<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\FacebookOAuthService;
use App\Services\GoogleOAuthService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class OAuthController extends Controller
{
    /**
     * Google OAuth Service
     */
    protected GoogleOAuthService $googleOAuth;

    /**
     * Facebook OAuth Service
     */
    protected FacebookOAuthService $facebookOAuth;

    /**
     * Constructor
     */
    public function __construct(GoogleOAuthService $googleOAuth, FacebookOAuthService $facebookOAuth)
    {
        $this->googleOAuth = $googleOAuth;
        $this->facebookOAuth = $facebookOAuth;
    }

    /**
     * Redirect to Google OAuth provider
     */
    public function redirectToGoogle(): RedirectResponse
    {
        try {
            if (!GoogleOAuthService::isConfigured()) {
                return redirect()->route('login')
                    ->with('error', 'Google OAuth is not configured. Please add credentials in admin settings.');
            }

            $state = Str::random(40);
            Session::put('oauth.google.state', $state);

            $authUrl = $this->googleOAuth->getAuthorizationUrl($state);
            return redirect($authUrl);
        } catch (Exception $e) {
            Log::error('Google redirect error: ' . $e->getMessage());
            return redirect()->route('login')
                ->with('error', 'Unable to connect to Google. Please try again later.');
        }
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback(): RedirectResponse
    {
        try {
            // Validate state parameter for CSRF protection
            $state = request('state');
            $storedState = Session::get('oauth.google.state');

            if (!$state || $state !== $storedState) {
                Log::warning('Google OAuth state mismatch detected');
                return redirect()->route('login')
                    ->with('error', 'Invalid state parameter. Please try again.');
            }

            // Check for authorization code
            $code = request('code');
            if (!$code) {
                $error = request('error', 'Unknown error');
                Log::warning('Google OAuth error: ' . $error);
                return redirect()->route('login')
                    ->with('error', 'Authorization failed. Error: ' . $error);
            }

            // Exchange code for access token
            $tokenData = $this->googleOAuth->getAccessToken($code);
            if (!$tokenData) {
                return redirect()->route('login')
                    ->with('error', 'Unable to obtain access token from Google.');
            }

            // Get user information
            $googleUser = $this->googleOAuth->getUserInfo($tokenData['access_token']);
            if (!$googleUser) {
                return redirect()->route('login')
                    ->with('error', 'Unable to retrieve your Google profile information.');
            }

            // Find or create user
            $user = $this->googleOAuth->findOrCreateUser($googleUser);
            if (!$user) {
                return redirect()->route('login')
                    ->with('error', 'Unable to create or find your account.');
            }

            // Authenticate user
            Auth::login($user, remember: true);
            Session::forget('oauth.google.state');

            Log::info('User logged in via Google', ['user_id' => $user->id, 'email' => $user->email]);

            return redirect()->intended(route('home'))
                ->with('success', 'Successfully logged in with Google!');
        } catch (Exception $e) {
            Log::error('Google callback error: ' . $e->getMessage());
            return redirect()->route('login')
                ->with('error', 'An unexpected error occurred. Please try again.');
        }
    }

    /**
     * Redirect to Facebook OAuth provider
     */
    public function redirectToFacebook(): RedirectResponse
    {
        try {
            if (!FacebookOAuthService::isConfigured()) {
                return redirect()->route('login')
                    ->with('error', 'Facebook OAuth is not configured. Please add credentials in admin settings.');
            }

            $state = Str::random(40);
            Session::put('oauth.facebook.state', $state);

            $authUrl = $this->facebookOAuth->getAuthorizationUrl($state);
            return redirect($authUrl);
        } catch (Exception $e) {
            Log::error('Facebook redirect error: ' . $e->getMessage());
            return redirect()->route('login')
                ->with('error', 'Unable to connect to Facebook. Please try again later.');
        }
    }

    /**
     * Handle Facebook OAuth callback
     */
    public function handleFacebookCallback(): RedirectResponse
    {
        try {
            // Validate state parameter for CSRF protection
            $state = request('state');
            $storedState = Session::get('oauth.facebook.state');

            if (!$state || $state !== $storedState) {
                Log::warning('Facebook OAuth state mismatch detected');
                return redirect()->route('login')
                    ->with('error', 'Invalid state parameter. Please try again.');
            }

            // Check for authorization code
            $code = request('code');
            if (!$code) {
                $error = request('error', 'Unknown error');
                Log::warning('Facebook OAuth error: ' . $error);
                return redirect()->route('login')
                    ->with('error', 'Authorization failed. Error: ' . $error);
            }

            // Exchange code for access token
            $tokenData = $this->facebookOAuth->getAccessToken($code);
            if (!$tokenData) {
                return redirect()->route('login')
                    ->with('error', 'Unable to obtain access token from Facebook.');
            }

            // Get user information
            $facebookUser = $this->facebookOAuth->getUserInfo($tokenData['access_token']);
            if (!$facebookUser) {
                return redirect()->route('login')
                    ->with('error', 'Unable to retrieve your Facebook profile information.');
            }

            // Find or create user
            $user = $this->facebookOAuth->findOrCreateUser($facebookUser);
            if (!$user) {
                return redirect()->route('login')
                    ->with('error', 'Unable to create or find your account.');
            }

            // Authenticate user
            Auth::login($user, remember: true);
            Session::forget('oauth.facebook.state');

            Log::info('User logged in via Facebook', ['user_id' => $user->id, 'email' => $user->email]);

            return redirect()->intended(route('home'))
                ->with('success', 'Successfully logged in with Facebook!');
        } catch (Exception $e) {
            Log::error('Facebook callback error: ' . $e->getMessage());
            return redirect()->route('login')
                ->with('error', 'An unexpected error occurred. Please try again.');
        }
    }
}
