<?php

namespace App\Http\Controllers;
use App\Models\Experience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Exception;

class ExperienceController extends Controller
{
   public function showExperience()
    {
        $experiences = Experience::latest()->get();
        return view('pages.experience.index', compact('experiences'));
    }

    public function addExperience()
    {
        return view('pages.experience.add');
    }

    public function storeExperience(Request $request)
    {
        // ✅ Validation
        $request->validate([
            'title' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'company_link' => 'nullable|url',
            'content' => 'required|string',
        ]);

        try {
            Experience::create([
                'title' => $request->title,
                'duration' => $request->duration,
                'company_link' => $request->company_link,
                'content' => $request->content,
            ]);

            return redirect()
                ->route('experience')
                ->with('success', 'Experience added successfully!');
        } catch (Exception $e) {

            // ✅ Error logging
            Log::error('Experience Store Error: '.$e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'Something went wrong while saving experience. Please try again.']);
        }
    }

    public function editExperience($id)
    {
        try {
            $experience = Experience::findOrFail($id);
            return view('pages.experience.edit', compact('experience'));
        } catch (Exception $e) {
            Log::error('Experience Edit Error', [
                'message' => $e->getMessage(),
                'id' => $id
            ]);

            return redirect()->route('experience')
                ->with('error', 'Experience record not found.');
        }
    }

    public function updateExperience(Request $request, $id)
    {
        // ✅ Validation
        $request->validate([
            'title'        => 'required|string|max:255',
            'duration'     => 'required|string|max:255',
            'company_link' => 'nullable|url',
            'content'      => 'required|string',
        ]);

        try {
            $experience = Experience::findOrFail($id);

            // ✅ Update fields
            $experience->update([
                'title'        => $request->title,
                'duration'     => $request->duration,
                'company_link' => $request->company_link,
                'content'      => $request->content,
            ]);

            return redirect()
                ->route('experience')
                ->with('success', 'Experience updated successfully.');

        } catch (Exception $e) {

            // ✅ Log error
            Log::error('Experience Update Error', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'id'      => $id
            ]);

            return back()
                ->withInput()
                ->with('error', 'Something went wrong while updating experience.');
        }
    }

    public function deleteExperience($id)
    {
        try {
            $experience = Experience::findOrFail($id);

            $experience->delete();

            return redirect()->route('experience')
                ->with('success', 'Experience record deleted successfully.');

        } catch (Exception $e) {
            Log::error('Experience Delete Error', [
                'message' => $e->getMessage(),
                'id' => $id
            ]);

            return redirect()->route('experience')
                ->with('error', 'Failed to delete experience record.');
        }
    }
}