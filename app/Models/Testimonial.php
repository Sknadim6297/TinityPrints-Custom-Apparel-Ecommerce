<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_name',
        'author_desc',
        'content',
        'image_path',
        'is_active',
        'sort_order',
    ];
}
