<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'mobile_phone',
        'hotline_phone',
        'address',
        'email_primary',
        'email_secondary',
    ];
}
