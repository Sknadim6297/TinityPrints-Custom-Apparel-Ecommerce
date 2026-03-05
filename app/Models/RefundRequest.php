<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefundRequest extends Model
{
    public const STATUS_REFUND_REQUESTED = 'refund_requested';
    public const STATUS_UNDER_REVIEW = 'under_review';
    public const STATUS_REFUND_APPROVED = 'refund_approved';
    public const STATUS_REFUND_REJECTED = 'refund_rejected';
    public const STATUS_PENDING_CUSTOMER_RESPONSE = 'pending_customer_response';
    public const STATUS_RETURN_IN_PROCESS = 'return_in_process';
    public const STATUS_PRODUCT_RECEIVED = 'product_received';
    public const STATUS_REFUND_COMPLETED = 'refund_completed';

    protected $fillable = [
        'ticket_id',
        'order_id',
        'reason',
        'reason_code',
        'description',
        'proof_path',
        'evidence_path',
        'product_type',
        'status',
        'admin_note',
        'customer_response',
        'customer_response_at',
        'delivery_date',
        'return_mode',
        'return_initiated_at',
        'product_received_at',
        'refund_method',
        'refund_amount',
        'refund_completed_at',
        'approved_at',
        'rejected_at',
        'paid_at',
        'notified_at',
    ];

    protected $casts = [
        'refund_amount' => 'decimal:2',
        'customer_response_at' => 'datetime',
        'delivery_date' => 'datetime',
        'return_initiated_at' => 'datetime',
        'product_received_at' => 'datetime',
        'refund_completed_at' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'paid_at' => 'datetime',
        'notified_at' => 'datetime',
    ];

    public static function statusOptions(): array
    {
        return [
            self::STATUS_REFUND_REQUESTED,
            self::STATUS_UNDER_REVIEW,
            self::STATUS_REFUND_APPROVED,
            self::STATUS_REFUND_REJECTED,
            self::STATUS_PENDING_CUSTOMER_RESPONSE,
            self::STATUS_RETURN_IN_PROCESS,
            self::STATUS_PRODUCT_RECEIVED,
            self::STATUS_REFUND_COMPLETED,
        ];
    }

    public function getReadableStatusAttribute(): string
    {
        return ucwords(str_replace('_', ' ', $this->status));
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
