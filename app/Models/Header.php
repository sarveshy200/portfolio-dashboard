<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Header extends Model
{
    protected $fillable = [
        'title',
        'content',
        'social_links',
    ];

    /**
     * Cast the social_links JSON to an array.
     */
    protected $casts = [
        'social_links' => 'array',
    ];
}