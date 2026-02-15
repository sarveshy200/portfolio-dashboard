<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ContactInquiry;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        $totalProjects = Project::count();
        $totalContacts = ContactInquiry::count();

        return view('dashboard', compact(
            'totalProjects',
            'totalContacts'
        ));
    }
}
