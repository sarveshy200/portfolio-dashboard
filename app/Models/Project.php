<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'link',
        'github_link',
        'image',
        'technologies',
    ];

    protected $casts = [
        'technologies' => 'array',
    ];
}
