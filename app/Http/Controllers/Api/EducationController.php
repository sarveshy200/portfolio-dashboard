<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Education;

class EducationController extends Controller
{
    public function index()
    {
        $education = Education::all();

        return response()->json([
            'success' => true,
            'data' => $education
        ]);
    }
}
