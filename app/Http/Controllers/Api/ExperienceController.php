<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Experience;

class ExperienceController extends Controller
{
    public function index()
    {
        $experience = Experience::all();

        return response()->json([
            'success' => true,
            'data' => $experience
        ]);
    }
}
