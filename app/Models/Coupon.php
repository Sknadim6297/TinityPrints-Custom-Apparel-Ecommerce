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
        'per_customer_usage_limit',
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
     * Get the number of times a user has used this coupon
     */
    public function getUserUsageCount($userId): int
    {
        return $this->usedByUsers()->where('user_id', $userId)->count();
    }

    /**
     * Check if a user has already used this coupon
     * @deprecated Use getUserUsageCount() and hasReachedUsageLimit() instead
     */
    public function hasBeenUsedByUser($userId): bool
    {
        return $this->usedByUsers()->where('user_id', $userId)->exists();
    }

    /**
     * Check if a user has reached the per-customer usage limit for this coupon
     */
    public function hasReachedUsageLimit($userId): bool
    {
        // If no per-customer usage limit is set, coupon can be used unlimited times by each customer
        if (!$this->per_customer_usage_limit) {
            return false;
        }

        $usageCount = $this->getUserUsageCount($userId);
        return $usageCount >= $this->per_customer_usage_limit;
    }

    /**
     * Check if the coupon has reached its total usage limit (across all customers)
     */
    public function hasReachedTotalUsageLimit(): bool
    {
        // If no total usage limit is set, coupon can be used unlimited times
        if (!$this->usage_limit) {
            return false;
        }

        return $this->usage_count >= $this->usage_limit;
    }

    /**
     * Mark coupon as used by a user
     */
    public function markAsUsedByUser($userId): void
    {
        $this->usedByUsers()->attach($userId);
    }
}
