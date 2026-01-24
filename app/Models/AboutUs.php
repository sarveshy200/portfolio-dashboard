<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory;

    // Matches the table name created in migration
    protected $table = 'about_us';

    protected $fillable = [
        'name',
        'about_content',
        'profile_image',
        'resume',
    ];
}