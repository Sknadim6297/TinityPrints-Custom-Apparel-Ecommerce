<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'provider_name',
        'provider_id',
        'avatar',
        'social_email',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function loginHistories()
    {
        return $this->hasMany(LoginHistory::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function defaultAddress()
    {
        return $this->hasOne(UserAddress::class)->where('is_default', true);
    }

    public function usedCoupons()
    {
        return $this->belongsToMany(Coupon::class, 'coupon_user_usage', 'user_id', 'coupon_id')
            ->withTimestamps();
    }

    public function loginProviderLabel(): string
    {
        return match ($this->provider_name) {
            'facebook' => 'Facebook',
            'google' => 'Google',
            default => 'Email/Password',
        };
    }

    public function isOAuthUser(): bool
    {
        return in_array($this->provider_name, ['facebook', 'google'], true);
    }

    public function displayEmail(): string
    {
        if ($this->social_email) {
            return $this->social_email;
        }

        if ($this->isOAuthUser() && str_ends_with($this->email, '@local.app')) {
            return '—';
        }

        return $this->email;
    }
}
