<?php
/**
 * OAuth Implementation Notes
 * 
 * This file documents the OAuth implementation architecture and design decisions
 * for quick reference during development and maintenance.
 */

/*
=======================================================================
ARCHITECTURE OVERVIEW
=======================================================================

The OAuth implementation follows a clean, scalable architecture:

[Login Page] 
    ↓
[OAuthController::redirectToGoogle/redirectToFacebook]
    ↓
[User Authorization on Provider]
    ↓
[Provider Redirects to Callback URL]
    ↓
[OAuthController::handleGoogleCallback/handleFacebookCallback]
    ↓
[OAuth Service: getAccessToken() → getUserInfo()]
    ↓
[OAuth Service: findOrCreateUser()]
    ↓
[Database: Create/Link User]
    ↓
[Auth::login()]
    ↓
[Redirect to Home]

=======================================================================
SERVICE PATTERN
=======================================================================

Each OAuth provider has a dedicated Service class:
- GoogleOAuthService
- FacebookOAuthService

This separation allows:
- Easy addition of new providers (TwitterOAuthService, LinkedInOAuthService, etc.)
- Provider-specific logic isolation
- Testability
- Code reusability

=======================================================================
WORKFLOW DETAILS
=======================================================================

1. INITIATION PHASE
   ---
   User clicks "Login with Google/Facebook" button
   
   Route: GET /auth/oauth/{provider}
   Method: OAuthController::redirectToGoogle() or redirectToFacebook()
   
   Actions:
   - Generate random state token (CSRF protection)
   - Store in session: Session::put('oauth.{provider}.state', $state)
   - Generate OAuth URL with scopes and redirect
   - Redirect user to provider

2. AUTHORIZATION PHASE
   ---
   User logs in to Google/Facebook and grants permissions
   Provider redirects back to callback URL with code + state
   
3. CALLBACK PHASE
   ---
   Route: GET /auth/oauth/{provider}/callback?code=...&state=...
   Method: OAuthController::handleGoogleCallback() or handleFacebookCallback()
   
   Steps:
   a) CSRF Validation
      - Verify state parameter matches session state
      - Prevents CSRF attacks
      
   b) Code Validation
      - Check authorization code exists
      - Check for auth errors from provider
      
   c) Token Exchange
      - Send code + client_id + secret to provider
      - Receive access_token + refresh_token + expires_in
      - Handle token exchange errors
      
   d) User Info Retrieval
      - Use access_token to call user info endpoint
      - Parse user data (email, name, picture, etc.)
      - Handle profile fetch errors
      
   e) User Resolution
      - Call OAuth Service: findOrCreateUser($userData)
      - Service handles:
        * Looking up by provider_id
        * Looking up by email (if new provider)
        * Creating new account
        * Linking social account to existing email
      
   f) Authentication
      - Auth::login($user, remember: true)
      - Sets auth session + remember cookie
      
   g) Redirect
      - Redirect to home or intended route
      - Show success message

=======================================================================
DATABASE STRATEGY
=======================================================================

User Model Fillable Array:
protected $fillable = [
    'name',
    'email',
    'phone',
    'password',
    'role',
    'provider_name',      // NEW: 'google' or 'facebook'
    'provider_id',        // NEW: provider's unique user ID
    'avatar',             // NEW: profile picture URL
    'social_email',       // NEW: email from provider
];

Unique Index:
- Prevents duplicate social accounts per provider
- Allows same email from different providers
- Query: SELECT * FROM users WHERE provider_name='google' AND provider_id='123'

Account Linking Logic:

Scenario 1: First-time OAuth login
- No user with provider_id
- No user with email
- Result: Create new user with OAuth data

Scenario 2: OAuth with existing email
- No user with provider_id
- User exists with same email
- Result: Link OAuth provider to existing user

Scenario 3: Returning OAuth login
- User exists with provider_id
- Result: Update user info (avatar, email) and login

Scenario 4: Both providers, same email
- GoogleUser (email: user@example.com)
- FacebookUser (email: user@example.com)
- Result: Same database user with both providers linked
  - Last provider to link overwrites provider_name/provider_id
  - Consider enhancement: Allow multiple providers per user

=======================================================================
ERROR HANDLING STRATEGY
=======================================================================

Multiple layers of error handling:

1. Configuration Errors
   - Check: GoogleOAuthService::isConfigured()
   - Action: Hide buttons, show message
   - Log: Warning in logs

2. Network Errors
   - Try-catch blocks around HTTP calls
   - Timeout handling
   - Log: Error details
   - User: Friendly error message

3. OAuth Protocol Errors
   - State mismatch: CSRF attack attempt
   - Missing code: User denied access
   - Token exchange failure: Invalid credentials
   - Log: Each error with details
   - User: Redirect to login with error

4. Data Errors
   - Missing email: Create local email
   - Invalid data: Validation and sanitization
   - Database errors: Catch and log
   - User: Error message, retry option

All errors logged to: storage/logs/laravel.log
Format: [timestamp] channel.LEVEL: message {"context": "data"}

=======================================================================
SECURITY CONSIDERATIONS
=======================================================================

1. CSRF Protection
   - Use: State parameter validation
   - How: Generate random state, store in session, verify on callback
   - Why: Prevents attacker from using victim's browser for OAuth

2. Session Security
   - Encrypt sessions: SESSION_ENCRYPT=true
   - Set expiry: SESSION_LIFETIME=120 minutes
   - HttpOnly cookies: Prevents JS access
   - SameSite: Strict (prevents CSRF)

3. Credential Security
   - Store in .env: GOOGLE_CLIENT_SECRET, etc.
   - Never log: Credentials never appear in logs
   - Environment-specific: Different creds per environment
   - Access control: Only web server accesses .env

4. HTTPS Requirement
   - Development: HTTP allowed (localhost)
   - Production: HTTPS required
   - Redirect URIs: Must match exactly (http vs https)
   - Cookies: Secure flag set in production

5. Input Validation
   - OAuth response: Validate all fields
   - Email: Sanitize and validate
   - Provider ID: String/numeric validation
   - User data: Type checking before use

=======================================================================
CONFIGURATION
=======================================================================

Config File: config/oauth.php

Returns:
[
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID', ''),
        'client_secret' => env('GOOGLE_CLIENT_SECRET', ''),
        'redirect_uri' => env('GOOGLE_REDIRECT_URI', ''),
    ],
    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID', ''),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET', ''),
        'redirect_uri' => env('FACEBOOK_REDIRECT_URI', ''),
    ],
]

Benefits:
- Centralized config
- Easy to extend
- Environment-specific
- Type-safe access

Usage:
config('oauth.google.client_id')
config('oauth.facebook.client_secret')

=======================================================================
TESTING APPROACH
=======================================================================

Unit Testing:
- Mock HTTP responses
- Test service methods independently
- Test findOrCreateUser logic

Integration Testing:
- Test full OAuth flow
- Mock provider responses
- Test user creation/linking
- Test error scenarios

Manual Testing:
- Login with Google on dev server
- Login with Facebook on dev server
- Test with multiple accounts
- Test new user creation
- Test existing user linking
- Test same email, different providers

Test Checklist:
[ ] User can login with Google
[ ] User can login with Facebook
[ ] New account created on first login
[ ] Existing account linked on second login
[ ] Profile picture updated
[ ] Email verified flag set
[ ] Error messages display correctly
[ ] Logs show all operations
[ ] CSRF protection works
[ ] Mobile responsive

=======================================================================
COMMON MODIFICATIONS
=======================================================================

Adding a New OAuth Provider (e.g., Twitter):

1. Create Service: TwitterOAuthService.php
   - Copy FacebookOAuthService as template
   - Implement Twitter API endpoints
   - Adjust user data mapping

2. Create Routes in routes/auth.php
   - GET /auth/oauth/twitter
   - GET /auth/oauth/twitter/callback

3. Add Controller Methods in OAuthController
   - redirectToTwitter()
   - handleTwitterCallback()

4. Update .env
   - TWITTER_CLIENT_ID=
   - TWITTER_CLIENT_SECRET=
   - TWITTER_REDIRECT_URI=

5. Update config/oauth.php
   - Add twitter section

6. Update Views
   - Add button to login.blade.php
   - Add button to register.blade.php

7. Update CSS
   - Add .sign-twitter button styles

Total effort: 2-3 hours per provider

=======================================================================
PERFORMANCE CONSIDERATIONS
=======================================================================

Database Queries:
1. SELECT by provider_id: Indexed query (fast)
2. SELECT by email: Indexed in users table (fast)
3. INSERT new user: Standard insert (fast)
4. UPDATE existing user: Standard update (fast)

HTTP Requests:
1. Authorization URL: Redirect (instant)
2. OAuth provider login: User controlled
3. Token exchange: ~200ms typically
4. User info request: ~200ms typically
5. Total flow time: 5-30 seconds (user dependent)

Caching Opportunities:
- Cache isConfigured() checks? Minimal benefit
- Cache user lookups? User-specific, not beneficial
- Cache OAuth tokens? Would need refresh logic

Current optimization:
- Direct queries, no N+1
- Indexed lookups
- Minimal database operations
- Efficient user resolution logic

=======================================================================
MAINTENANCE NOTES
=======================================================================

Regular Tasks:
- Monitor error logs: grep oauth storage/logs/laravel.log
- Review failed logins: Look for state mismatch, token errors
- Update API versions: Monitor provider changelog
- Test with rate limiting: Ensure handles 429 responses
- Security updates: Monitor for oauth vulnerabilities

Monitoring:
- New user creation: Should match signup patterns
- Failed OAuth attempts: Track trends
- Token refresh failures: May need credential rotation
- API rate limits: Should be rare

Debugging Steps:
1. Check .env has credentials: config('oauth.google.client_id')
2. Check routes exist: php artisan route:list | grep oauth
3. Check migration ran: DB::table('users')->getColumns()
4. Check logs: tail -f storage/logs/laravel.log
5. Test with curl: Verify provider endpoints
6. Test with browser: Full flow test
7. Check session storage: Is state being stored?

=======================================================================
FUTURE ENHANCEMENTS
=======================================================================

Potential Improvements:

1. Multi-Provider Per User
   - Allow linking multiple social accounts
   - Choose which to login with
   - DB change: Remove provider_id unique constraint

2. Token Refresh
   - Store refresh_token
   - Auto-refresh before expiry
   - Keep user info current

3. Disconnect Social Account
   - User dashboard
   - Unlink provider
   - Require password setup first

4. Social Profile Sync
   - Periodic sync of profile data
   - Update avatar, name from provider
   - Manual sync option

5. OAuth Scopes Management
   - Request additional scopes as needed
   - Handle scope changes
   - Graceful degradation if limited scopes

6. Two-Factor Authentication
   - Combine OAuth with 2FA
   - SMS/Email verification
   - Recovery codes

7. Analytics
   - Track OAuth signups vs email signups
   - Monitor provider performance
   - Geographic distribution of logins

8. Rate Limiting
   - Throttle token exchange attempts
   - Prevent brute force attacks
   - Gradual backoff on failures

=======================================================================
*/

// This file is for documentation only.
// No executable code here - it's a reference guide.
?>
