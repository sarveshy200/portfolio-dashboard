<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    // 👇 FORCE correct table name
    protected $table = 'educations';

    protected $fillable = [
        'college_name',
        'course',
        'duration',
        'college_link',
        'college_image',
    ];
}
