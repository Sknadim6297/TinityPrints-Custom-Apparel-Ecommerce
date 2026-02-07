<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesignRequest extends Model
{
    protected $fillable = [
        'customer_name',
        'phone',
        'email',
        'selected_size',
        'design_file_path',
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
        'payment_unlocked',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'payment_unlocked' => 'boolean',
        'file_locked' => 'boolean',
        'reviewed_at' => 'datetime',
        'file_updated_at' => 'datetime',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'reviewed_by');
    }
}
