<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Exception;

class AboutusController extends Controller
{
    public function showAboutus()
    {
        $abouts = AboutUs::latest()->get();
        return view('pages.about-us.index', compact('abouts'));
    }

    public function addAbout()
    {
        return view('pages.about-us.add');
    }

    public function storeAbout(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'about_content' => 'required|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:20480',
            'resume' => 'nullable|mimes:pdf,doc,docx|max:20480',
        ]);

        try {
            $data = $request->only(['name', 'about_content']);

            // Profile Image
            if ($request->hasFile('profile_image')) {
                $data['profile_image'] = $request->file('profile_image')
                    ->store('about/images', 'public');
            }

            // Resume
            if ($request->hasFile('resume')) {
                $data['resume'] = $request->file('resume')
                    ->store('about/resumes', 'public');
            }

            AboutUs::create($data);

            return redirect()->route('aboutus')
                ->with('success', 'About Us profile saved successfully!');

        } catch (\Exception $e) {
            Log::error('AboutUs Store Error: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Failed to save profile. Please try again.');
        }
    }


    public function editAbout($id)
    {
        $about = AboutUs::findOrFail($id);
        return view('pages.about-us.edit', compact('about'));
    }

    public function updateAbout(Request $request, $id)
    {
        $about = AboutUs::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'about_content' => 'required|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:20480',
            'resume' => 'nullable|mimes:pdf,doc,docx|max:20480',
        ]);

        try {
            $data = $request->only(['name', 'about_content']);

            // Handle Profile Image Update
            if ($request->hasFile('profile_image')) {
                // Delete old image if it exists
                if ($about->profile_image) {
                    Storage::disk('public')->delete($about->profile_image);
                }
                $data['profile_image'] = $request->file('profile_image')
                    ->store('about/images', 'public');
            }

            // Handle Resume Update
            if ($request->hasFile('resume')) {
                // Delete old resume if it exists
                if ($about->resume) {
                    Storage::disk('public')->delete($about->resume);
                }
                $data['resume'] = $request->file('resume')
                    ->store('about/resumes', 'public');
            }

            $about->update($data);

            return redirect()->route('aboutus')
                ->with('success', 'About Us profile updated successfully!');

        } catch (Exception $e) {
            Log::error('AboutUs Update Error: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Failed to update profile. Please try again.');
        }
    }

    public function deleteAbout($id)
    {
        try {
            // Find the record
            $about = AboutUs::findOrFail($id);

            // 1. Delete the profile image from storage if it exists
            if ($about->profile_image && Storage::disk('public')->exists($about->profile_image)) {
                Storage::disk('public')->delete($about->profile_image);
            }

            // 2. Delete the resume file from storage if it exists
            if ($about->resume && Storage::disk('public')->exists($about->resume)) {
                Storage::disk('public')->delete($about->resume);
            }

            // 3. Delete the database record
            $about->delete();

            // 4. Return success toast
            return redirect()->route('aboutus')->with('success', 'Profile and associated files deleted successfully!');

        } catch (Exception $e) {
            // Log the error for debugging
            Log::error('AboutUs Delete Error: ' . $e->getMessage());

            return redirect()->route('aboutus')->with('error', 'Failed to delete the profile.');
        }
    }

}