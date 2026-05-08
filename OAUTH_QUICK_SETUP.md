# OAuth Setup Checklist

## Quick Reference Guide

### Pre-Implementation Checklist ✓

- [x] Database migration created
- [x] OAuth services implemented (Google & Facebook)
- [x] OAuth controller with callback handlers
- [x] Routes configured
- [x] Environment variables added to .env
- [x] OAuth config file created
- [x] Login page updated with OAuth buttons
- [x] Register page updated with OAuth buttons
- [x] CSS styling for buttons created
- [x] Documentation provided
- [x] Error handling implemented
- [x] CSRF protection with state validation
- [x] User model updated

### Implementation Steps (For Your Team)

#### Step 1: Database Setup (10 minutes)
```bash
# Run the migration
php artisan migrate
```

**What it does:**
- Adds `provider_name`, `provider_id`, `avatar`, `social_email` to users table
- Creates unique index on provider_name + provider_id
- Creates index on provider_name

#### Step 2: Google OAuth Setup (15-20 minutes)

1. Visit [Google Cloud Console](https://console.cloud.google.com/)
2. Create new project: "Tinnity OAuth"
3. Enable Google+ API
4. Create OAuth 2.0 credentials (Web application)
5. Set redirect URI: `http://your-domain/auth/oauth/google/callback`
6. Copy Client ID and Client Secret
7. Add to `.env`:
   ```env
   GOOGLE_CLIENT_ID=your-client-id
   GOOGLE_CLIENT_SECRET=your-client-secret
   GOOGLE_REDIRECT_URI=http://your-domain/auth/oauth/google/callback
   ```

#### Step 3: Facebook OAuth Setup (15-20 minutes)

1. Visit [Facebook Developers](https://developers.facebook.com/)
2. Create new app: "Tinnity OAuth"
3. Add Facebook Login product
4. Configure redirect URIs: `http://your-domain/auth/oauth/facebook/callback`
5. Copy App ID and App Secret
6. Add to `.env`:
   ```env
   FACEBOOK_CLIENT_ID=your-app-id
   FACEBOOK_CLIENT_SECRET=your-app-secret
   FACEBOOK_REDIRECT_URI=http://your-domain/auth/oauth/facebook/callback
   ```

#### Step 4: Verify Setup (5 minutes)

```bash
# Clear config cache
php artisan config:clear

# Test in tinker
php artisan tinker
> GoogleOAuthService::isConfigured()
> FacebookOAuthService::isConfigured()
```

Both should return `true`

#### Step 5: Test OAuth Flow (10 minutes)

1. Start development server: `php artisan serve`
2. Visit login page: `http://localhost:8000/login`
3. Click "Continue with Google" button
4. Complete Google authentication
5. Should be redirected and logged in
6. Repeat for Facebook

### Environment Variables Template

Copy to your `.env` file:

```env
# ===== OAuth Configuration =====

# Google OAuth
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI=http://localhost/auth/oauth/google/callback

# Facebook OAuth
FACEBOOK_CLIENT_ID=
FACEBOOK_CLIENT_SECRET=
FACEBOOK_REDIRECT_URI=http://localhost/auth/oauth/facebook/callback
```

### File Locations Reference

| File | Purpose |
|------|---------|
| `config/oauth.php` | OAuth configuration |
| `app/Services/GoogleOAuthService.php` | Google OAuth logic |
| `app/Services/FacebookOAuthService.php` | Facebook OAuth logic |
| `app/Http/Controllers/Auth/OAuthController.php` | OAuth callbacks |
| `routes/auth.php` | OAuth routes |
| `resources/views/auth/login.blade.php` | Login page with buttons |
| `resources/views/auth/register.blade.php` | Register page with buttons |
| `resources/css/oauth.css` | OAuth button styling |
| `database/migrations/2026_05_08_000000_add_oauth_fields_to_users_table.php` | Database migration |
| `OAUTH_SETUP_GUIDE.md` | Complete documentation |

### Database Fields Added

```sql
ALTER TABLE users ADD COLUMN provider_name VARCHAR(255) NULL;
ALTER TABLE users ADD COLUMN provider_id VARCHAR(255) NULL;
ALTER TABLE users ADD COLUMN avatar VARCHAR(255) NULL;
ALTER TABLE users ADD COLUMN social_email VARCHAR(255) NULL;
ALTER TABLE users ADD UNIQUE KEY `unique_provider` (`provider_name`, `provider_id`);
ALTER TABLE users ADD INDEX `idx_provider_name` (`provider_name`);
```

### Routes Available

```
GET  /auth/oauth/google                 → redirectToGoogle()
GET  /auth/oauth/google/callback        → handleGoogleCallback()
GET  /auth/oauth/facebook               → redirectToFacebook()
GET  /auth/oauth/facebook/callback      → handleFacebookCallback()
```

### Service Methods

**GoogleOAuthService:**
- `getAuthorizationUrl($state)` - Get Google login URL
- `getAccessToken($code)` - Exchange code for token
- `getUserInfo($accessToken)` - Get user profile
- `findOrCreateUser($googleUser)` - Create or fetch user
- `isConfigured()` - Check if configured

**FacebookOAuthService:**
- `getAuthorizationUrl($state)` - Get Facebook login URL
- `getAccessToken($code)` - Exchange code for token
- `getUserInfo($accessToken)` - Get user profile
- `findOrCreateUser($facebookUser)` - Create or fetch user
- `isConfigured()` - Check if configured

### Common Issues & Quick Fixes

| Issue | Solution |
|-------|----------|
| Buttons not showing | Check `.env` has credentials. Run `php artisan config:clear` |
| "Invalid state" error | Clear cookies. Check redirect URI exactly matches settings |
| "Can't get token" error | Verify credentials in `.env`. Check redirect URI in provider settings |
| Email not syncing | User didn't grant email permission. Check logs for details |
| User not being created | Check database migration ran. Check user model fillable array |

### Testing Credentials (For Development)

Use these test accounts:

**Google:**
- Use your personal Google account
- Make sure testing enabled in Google Console

**Facebook:**
- Add test account in Facebook Developer Settings
- App must be in Development mode

### Production Deployment Checklist

- [ ] Database migration applied
- [ ] APP_ENV=production in .env
- [ ] APP_DEBUG=false in .env
- [ ] Production credentials in .env
- [ ] Redirect URIs updated to production domain
- [ ] HTTPS enforced
- [ ] OAuth apps approved (not in review)
- [ ] Test OAuth flow on production
- [ ] Monitor logs for errors
- [ ] Set up error alerts

### Monitoring & Logs

View OAuth-related logs:

```bash
# Show last 50 lines
tail -n 50 storage/logs/laravel.log

# Search for OAuth errors
grep -i oauth storage/logs/laravel.log

# Watch logs in real-time
tail -f storage/logs/laravel.log
```

### User Data After OAuth

When user logs in via OAuth, these fields are populated:

```php
$user = User::find(1);
$user->provider_name      // 'google' or 'facebook'
$user->provider_id        // '123456789'
$user->avatar             // URL to avatar
$user->social_email       // Email from provider
$user->email_verified_at  // Set to now()
$user->role               // 'customer'
```

### API Response Handling

**Google Response:**
```php
{
    "sub": "google-user-id",
    "email": "user@gmail.com",
    "name": "User Name",
    "picture": "https://avatar-url"
}
```

**Facebook Response:**
```php
{
    "id": "facebook-user-id",
    "email": "user@facebook.com",
    "name": "User Name",
    "picture": {
        "data": {
            "url": "https://avatar-url"
        }
    }
}
```

### Security Notes

1. **CSRF Protection**: State parameter prevents CSRF attacks
2. **Session Security**: OAuth state stored in encrypted sessions
3. **Credential Storage**: All keys in `.env` (never commit!)
4. **Logging**: OAuth operations logged (no sensitive data)
5. **Error Handling**: Errors caught and logged safely

### Next Steps

1. Run migration: `php artisan migrate`
2. Get Google credentials
3. Get Facebook credentials
4. Add to `.env`
5. Test flow locally
6. Deploy to production
7. Monitor logs

### Support Resources

- Complete guide: `OAUTH_SETUP_GUIDE.md`
- Google docs: https://developers.google.com/identity/protocols/oauth2
- Facebook docs: https://developers.facebook.com/docs/facebook-login
- Code location: `app/Services/`, `app/Http/Controllers/Auth/`

---

**Status**: ✅ Production Ready
**Last Updated**: May 8, 2026
**Next Review**: After first production deployment
