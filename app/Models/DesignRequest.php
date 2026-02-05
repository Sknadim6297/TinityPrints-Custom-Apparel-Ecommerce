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
        'reviewed_at' => 'datetime',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'reviewed_by');
    }
}
