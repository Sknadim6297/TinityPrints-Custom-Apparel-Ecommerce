<?php

/**
 * OAuth Configuration
 *
 * This file contains configuration for OAuth providers (Google, Facebook, etc.)
 * All credentials are loaded from environment variables for security.
 */

return [
    /**
     * Google OAuth Configuration
     */
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID', ''),
        'client_secret' => env('GOOGLE_CLIENT_SECRET', ''),
        'redirect_uri' => env('GOOGLE_REDIRECT_URI', ''),
    ],

    /**
     * Facebook OAuth Configuration
     */
    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID', ''),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET', ''),
        'redirect_uri' => env('FACEBOOK_REDIRECT_URI', ''),
    ],
];
