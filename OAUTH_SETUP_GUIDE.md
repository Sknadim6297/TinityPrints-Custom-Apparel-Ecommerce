# OAuth Implementation Guide

## Overview

This document provides a complete guide for implementing and configuring Google and Facebook OAuth login functionality in the Tinnity e-commerce application.

## Features Implemented

✅ **Google OAuth Login**
- Complete OAuth 2.0 flow integration
- Automatic user creation and linking
- Profile picture and email sync
- Email verification via OAuth provider

✅ **Facebook OAuth Login**
- Facebook Graph API integration
- User profile sync
- Automatic account creation
- Email handling for accounts without public email

✅ **Security Features**
- CSRF protection with state parameter validation
- Secure session handling
- Encrypted credentials storage
- Proper error handling and logging

✅ **Database Integration**
- Social login provider tracking
- User avatar storage
- Provider email tracking
- Duplicate account prevention

✅ **User Experience**
- Mobile-responsive buttons
- Seamless account linking
- Error messages
- Auto-login after OAuth completion

## Database Schema

### Users Table Additions

New fields added to the `users` table:

```sql
- provider_name (string, nullable) - OAuth provider name (google, facebook)
- provider_id (string, nullable) - Unique ID from OAuth provider
- avatar (string, nullable) - User avatar URL from provider
- social_email (string, nullable) - Email from OAuth provider
```

**Unique Constraint:**
- `provider_name` + `provider_id` combination is unique
- Prevents duplicate social accounts

**Index:**
- `provider_name` is indexed for faster lookups

## File Structure

```
app/
├── Http/Controllers/Auth/
│   └── OAuthController.php          # OAuth callback handlers
├── Services/
│   ├── GoogleOAuthService.php       # Google OAuth logic
│   └── FacebookOAuthService.php     # Facebook OAuth logic
config/
└── oauth.php                        # OAuth configuration
database/migrations/
└── 2026_05_08_000000_add_oauth_fields_to_users_table.php
resources/
├── css/
│   └── oauth.css                    # OAuth button styling
├── views/auth/
│   ├── login.blade.php              # Updated with OAuth buttons
│   └── register.blade.php           # Updated with OAuth buttons
routes/
└── auth.php                         # OAuth routes
```

## Setup Instructions

### Step 1: Run Database Migration

Execute the migration to add OAuth fields to the users table:

```bash
php artisan migrate
```

### Step 2: Google OAuth Setup

#### Google Console Configuration

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project (or use existing)
3. Navigate to **APIs & Services** → **OAuth consent screen**
4. Choose **User Type**: External
5. Fill in the required information:
   - App name
   - User support email
   - Developer contact

6. Go to **APIs & Services** → **Credentials**
7. Click **Create Credentials** → **OAuth Client ID**
8. Choose **Web application**
9. Add authorized JavaScript origins:
   ```
   http://localhost
   http://localhost:8000
   https://yourdomain.com
   ```

10. Add authorized redirect URIs:
    ```
    http://localhost/auth/oauth/google/callback
    http://localhost:8000/auth/oauth/google/callback
    https://yourdomain.com/auth/oauth/google/callback
    ```

11. Copy the **Client ID** and **Client Secret**

#### Environment Configuration

Add to your `.env` file:

```env
GOOGLE_CLIENT_ID=your_google_client_id_here
GOOGLE_CLIENT_SECRET=your_google_client_secret_here
GOOGLE_REDIRECT_URI=http://localhost/auth/oauth/google/callback
```

**For Production:**

```env
GOOGLE_CLIENT_ID=your_production_client_id
GOOGLE_CLIENT_SECRET=your_production_secret
GOOGLE_REDIRECT_URI=https://yourdomain.com/auth/oauth/google/callback
```

### Step 3: Facebook OAuth Setup

#### Facebook Developer Configuration

1. Go to [Facebook Developers](https://developers.facebook.com/)
2. Create a new app (or use existing)
3. Add **Facebook Login** product
4. Navigate to **Settings** → **Basic**
5. Copy your **App ID** and **App Secret**
6. Go to **Facebook Login** → **Settings**
7. Add Valid OAuth Redirect URIs:
   ```
   http://localhost/auth/oauth/facebook/callback
   http://localhost:8000/auth/oauth/facebook/callback
   https://yourdomain.com/auth/oauth/facebook/callback
   ```

8. Go to **Roles** → **Roles** and add your test account
9. Set your App Domains:
   ```
   localhost
   yourdomain.com
   ```

#### Environment Configuration

Add to your `.env` file:

```env
FACEBOOK_CLIENT_ID=your_facebook_app_id
FACEBOOK_CLIENT_SECRET=your_facebook_app_secret
FACEBOOK_REDIRECT_URI=http://localhost/auth/oauth/facebook/callback
```

**For Production:**

```env
FACEBOOK_CLIENT_ID=your_production_app_id
FACEBOOK_CLIENT_SECRET=your_production_secret
FACEBOOK_REDIRECT_URI=https://yourdomain.com/auth/oauth/facebook/callback
```

## API Endpoints

### OAuth Routes

```
GET /auth/oauth/google
Redirects user to Google login page
Name: oauth.google

GET /auth/oauth/google/callback
Google OAuth callback handler
Name: oauth.google.callback

GET /auth/oauth/facebook
Redirects user to Facebook login page
Name: oauth.facebook

GET /auth/oauth/facebook/callback
Facebook OAuth callback handler
Name: oauth.facebook.callback
```

## Service Classes

### GoogleOAuthService

**Methods:**

```php
public function getAuthorizationUrl(string $state): string
// Returns Google OAuth authorization URL

public function getAccessToken(string $code): ?array
// Exchanges auth code for access token

public function getUserInfo(string $accessToken): ?array
// Retrieves user information from Google

public function findOrCreateUser(array $googleUser): ?User
// Finds existing user or creates new one

public static function isConfigured(): bool
// Checks if Google OAuth is properly configured
```

### FacebookOAuthService

**Methods:**

```php
public function getAuthorizationUrl(string $state): string
// Returns Facebook OAuth authorization URL

public function getAccessToken(string $code): ?array
// Exchanges auth code for access token

public function getUserInfo(string $accessToken): ?array
// Retrieves user information from Facebook

public function findOrCreateUser(array $facebookUser): ?User
// Finds existing user or creates new one

public static function isConfigured(): bool
// Checks if Facebook OAuth is properly configured
```

## Controllers

### OAuthController

**Endpoints:**

```php
public function redirectToGoogle(): RedirectResponse
// Initiates Google OAuth flow

public function handleGoogleCallback(): RedirectResponse
// Handles Google OAuth callback

public function redirectToFacebook(): RedirectResponse
// Initiates Facebook OAuth flow

public function handleFacebookCallback(): RedirectResponse
// Handles Facebook OAuth callback
```

## User Account Handling

### Account Creation Logic

1. **First Time Login**: User doesn't have account
   - New account is created automatically
   - Email is verified
   - Role is set to 'customer'
   - Password is empty (OAuth users don't need password)

2. **Existing Account**: User has account with same email
   - OAuth provider is linked to existing account
   - User can login with either social or email/password

3. **Duplicate Prevention**: Provider ID + Provider Name is unique
   - Same user cannot create multiple accounts per provider
   - Same email from different providers is allowed

## Frontend Integration

### Login Page

Location: `resources/views/auth/login.blade.php`

The login page now includes:
- Google login button
- Facebook login button
- Conditional display (only shows if OAuth is configured)
- Mobile-responsive design

### Register Page

Location: `resources/views/auth/register.blade.php`

The register page now includes:
- Google sign-up button
- Facebook sign-up button
- Automatic account creation via OAuth
- Mobile-responsive design

### CSS Styling

Location: `resources/css/oauth.css`

Includes:
- Button styling and animations
- Hover effects
- Mobile responsiveness
- Accessibility features
- Dark mode support

## Error Handling

The system handles the following scenarios:

### Configuration Errors
- Missing credentials in `.env`
- Invalid redirect URIs
- Buttons hidden if not configured

### OAuth Errors
- State mismatch (CSRF protection)
- Authorization denied by user
- Token exchange failures
- User info retrieval failures

### User Creation Errors
- Database errors
- Duplicate email handling
- Account linking failures

All errors are:
- Logged to `storage/logs/laravel.log`
- Displayed to user with friendly messages
- Redirected back to login page

## Logging

All OAuth operations are logged to `storage/logs/laravel.log`:

```
[2026-05-08 12:00:00] local.INFO: New user created via Google OAuth {"user_id":1,"email":"user@example.com"}
[2026-05-08 12:05:00] local.INFO: User logged in via Google {"user_id":1,"email":"user@example.com"}
[2026-05-08 12:10:00] local.ERROR: Google token exchange failed {"response":{...}}
```

## Security Considerations

### CSRF Protection

State parameter validation:
```php
$state = Str::random(40);
Session::put('oauth.google.state', $state);
// Later validate: request('state') === Session::get('oauth.google.state')
```

### Session Security

- OAuth state stored in session (lifetime: 120 minutes)
- Sessions encrypted via `SESSION_ENCRYPT` in config
- HTTPS recommended for production
- SameSite cookie protection enabled

### Credential Security

- All API credentials in `.env` (never hardcoded)
- Environment-specific configuration
- Credentials never logged
- Empty default values prevent accidents

## Testing OAuth Locally

### Local Development URL

Update `.env` for localhost:
```env
APP_URL=http://localhost:8000
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/oauth/google/callback
FACEBOOK_REDIRECT_URI=http://localhost:8000/auth/oauth/facebook/callback
```

### Testing with Ngrok (for external webhooks)

If you need a public URL for development:

```bash
ngrok http 8000
```

Then update your redirect URIs and `.env`:
```env
GOOGLE_REDIRECT_URI=https://your-ngrok-url/auth/oauth/google/callback
FACEBOOK_REDIRECT_URI=https://your-ngrok-url/auth/oauth/facebook/callback
```

### Test Accounts

- **Google**: Use your personal Google account
- **Facebook**: Use a test account from Facebook Developer settings

## Production Deployment

### Pre-deployment Checklist

- [ ] Set `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false` in `.env`
- [ ] Use HTTPS only
- [ ] Update all redirect URIs to production domain
- [ ] Add production domain to Google Console
- [ ] Add production domain to Facebook app settings
- [ ] Update API credentials for production
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Test OAuth flow on production

### Environment-Specific Configuration

```env
# Production
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
GOOGLE_REDIRECT_URI=https://yourdomain.com/auth/oauth/google/callback
FACEBOOK_REDIRECT_URI=https://yourdomain.com/auth/oauth/facebook/callback
```

## Troubleshooting

### OAuth buttons not showing

**Problem**: Social login buttons not visible on login page

**Solution**:
1. Check `.env` has credentials:
   ```php
   GoogleOAuthService::isConfigured() // Should return true
   FacebookOAuthService::isConfigured() // Should return true
   ```
2. Clear config cache: `php artisan config:clear`
3. Check if blade template is updated

### "Invalid state parameter" error

**Problem**: User gets state mismatch error

**Solution**:
1. Check session is working: `php artisan tinker` → `Session::get('oauth.google.state')`
2. Check redirect URI matches exactly in `.env` and provider settings
3. Ensure cookie domain matches (localhost vs 127.0.0.1)
4. Clear browser cookies and try again

### "Unable to obtain access token" error

**Problem**: Token exchange fails

**Solution**:
1. Verify credentials in `.env` are correct
2. Check redirect URI matches in provider settings exactly
3. Check application status in Google/Facebook console
4. Review error logs: `tail -f storage/logs/laravel.log`
5. Test with curl:
   ```bash
   curl -X POST https://oauth2.googleapis.com/token \
     -d "client_id=YOUR_ID&client_secret=YOUR_SECRET&code=AUTH_CODE&grant_type=authorization_code&redirect_uri=REDIRECT_URI"
   ```

### User email not syncing

**Problem**: User profile shows incorrect email

**Solution**:
1. Check user has provided email permission
2. Verify provider returns email in profile data
3. Check database: `SELECT * FROM users WHERE provider_id = 'YOUR_ID'`
4. Review logs for email handling errors

## Account Linking Examples

### Example 1: User with Gmail creates account

```
1. User clicks "Login with Google"
2. Authorizes and returns with email: user@gmail.com
3. No existing account with that email
4. New account created:
   - name: User Name
   - email: user@gmail.com
   - provider_name: google
   - provider_id: 123456789
   - avatar: (from Google)
   - role: customer
```

### Example 2: User links Facebook to existing account

```
1. User has account with email: user@gmail.com
2. User clicks "Login with Facebook"
3. Authorizes with same email: user@gmail.com
4. Existing account found
5. Facebook provider linked:
   - provider_name: facebook
   - provider_id: 987654321
   - avatar: updated
```

### Example 3: Duplicate provider prevention

```
1. User already has Google account linked
2. User clicks "Login with Google" again
3. Finds existing provider_name + provider_id combo
4. Updates user info (avatar, email)
5. User logged in
```

## API Response Examples

### Successful Google Login

```json
{
  "sub": "123456789",
  "email": "user@gmail.com",
  "email_verified": true,
  "name": "User Name",
  "picture": "https://lh3.googleusercontent.com/...",
  "aud": "YOUR_CLIENT_ID.apps.googleusercontent.com"
}
```

### Successful Facebook Login

```json
{
  "id": "123456789",
  "name": "User Name",
  "email": "user@facebook.com",
  "picture": {
    "data": {
      "height": 500,
      "is_silhouette": false,
      "url": "https://platform-lookaside.fbsbx.com/..."
    }
  }
}
```

## Support & Documentation Links

- **Google OAuth**: https://developers.google.com/identity/protocols/oauth2
- **Facebook Login**: https://developers.facebook.com/docs/facebook-login
- **Laravel Authentication**: https://laravel.com/docs/11.x/authentication
- **Laravel Sessions**: https://laravel.com/docs/11.x/session

## Future Enhancements

Possible improvements for future versions:

1. **Twitter OAuth** - Add Twitter login support
2. **LinkedIn OAuth** - For B2B functionality
3. **Two-Factor Authentication** - OAuth + 2FA
4. **OAuth Token Refresh** - Auto-refresh access tokens
5. **Social Profile Dashboard** - Manage linked accounts
6. **Discord OAuth** - For community features
7. **GitHub OAuth** - For developer authentication
8. **Apple OAuth** - For iOS users

## Support

For issues or questions:

1. Check error logs: `storage/logs/laravel.log`
2. Review this documentation
3. Check provider's developer console for status
4. Test with simple curl requests
5. Contact technical support with logs attached

---

**Last Updated**: May 8, 2026
**Version**: 1.0
**Status**: Production Ready
