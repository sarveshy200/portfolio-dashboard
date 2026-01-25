<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = ['section_title', 'section_content', 'skill_data'];

    protected $casts = [
        'skill_data' => 'array', // This converts the JSON from DB into a PHP array
    ];
}
