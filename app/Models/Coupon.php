<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'usage_limit',
        'usage_count',
        'expires_at',
        'min_order_value',
        'customer_email',
        'is_active',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'discount_value' => 'decimal:2',
        'min_order_value' => 'decimal:2',
    ];

    /**
     * Get users who have used this coupon
     */
    public function usedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'coupon_user_usage', 'coupon_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * Check if a user has already used this coupon
     */
    public function hasBeenUsedByUser($userId): bool
    {
        return $this->usedByUsers()->where('user_id', $userId)->exists();
    }

    /**
     * Mark coupon as used by a user
     */
    public function markAsUsedByUser($userId): void
    {
        $this->usedByUsers()->attach($userId);
    }
}
