<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesignRequest extends Model
{
    protected $fillable = [
        'user_id',
        'customer_name',
        'phone',
        'email',
        'selected_size',
        'sleeve_type',
        'color',
        'design_file_path',
        'front_design_file',
        'back_design_file',
        'notes',
        'file_format',
        'dpi',
        'print_width',
        'print_height',
        'print_unit',
        'file_locked',
        'file_checksum',
        'file_updated_at',
        'front_label',
        'back_label',
        'status',
        'remarks',
        'admin_remark',
        'price',
        'payment_status',
        'payment_unlocked',
        'reviewed_by',
        'reviewed_at',
        'order_id',
    ];

    protected $casts = [
        'payment_unlocked' => 'boolean',
        'file_locked' => 'boolean',
        'reviewed_at' => 'datetime',
        'file_updated_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'reviewed_by');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeRevisionRequested($query)
    {
        return $query->where('status', 'changes_requested');
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    public function scopeUnpaid($query)
    {
        return $query->where('payment_status', 'unpaid');
    }

    // Accessor methods
    public function canPay()
    {
        return $this->status === 'approved' 
            && $this->payment_status === 'unpaid' 
            && $this->payment_unlocked 
            && $this->price > 0;
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    public function requiresRevision()
    {
        return $this->status === 'changes_requested';
    }
}
