<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Header;

class HeaderController extends Controller
{
    public function index()
    {
        $header = Header::first();

        return response()->json([
            'success' => true,
            'data' => $header
        ]);
    }
}
