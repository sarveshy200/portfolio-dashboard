<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Exception;

class EducationController extends Controller
{
    public function showEducation()
    {
        $educations = Education::latest()->get();
        return view('pages.education.index', compact('educations'));
    }

    public function addEducation()
    {
        return view('pages.education.add');
    }

    public function storeEducation(Request $request)
    {
        // ✅ Validation
        $request->validate([
            'college_name'   => 'required|string|max:255',
            'course'         => 'required|string|max:255',
            'duration'       => 'required|string|max:100',
            'college_link'   => 'nullable|url',
            'college_image'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            $imagePath = null;

            // ✅ Image Upload
            if ($request->hasFile('college_image')) {
                $imagePath = $request->file('college_image')
                    ->store('education_logos', 'public');
            }

            // ✅ Store Data
            Education::create([
                'college_name'  => $request->college_name,
                'course'        => $request->course,
                'duration'      => $request->duration,
                'college_link'  => $request->college_link,
                'college_image' => $imagePath,
            ]);

            return redirect()->route('education')
                ->with('success', 'Education record added successfully.');

        } catch (Exception $e) {

            // ✅ Log Error
            Log::error('Education Store Error', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Something went wrong while saving education details.');
        }
    }


    public function editEducation($id)
    {
        try {
            $education = Education::findOrFail($id);
            return view('pages.education.edit', compact('education'));

        } catch (Exception $e) {
            Log::error('Education Edit Error', [
                'message' => $e->getMessage(),
                'id' => $id
            ]);

            return redirect()->route('education')
                ->with('error', 'Education record not found.');
        }
    }

     public function updateEducation(Request $request, $id)
    {
        // ✅ Validation
        $request->validate([
            'college_name'  => 'required|string|max:255',
            'course'        => 'required|string|max:255',
            'duration'      => 'required|string|max:100',
            'college_link'  => 'nullable|url',
            'college_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            $education = Education::findOrFail($id);

            // ✅ If new image uploaded
            if ($request->hasFile('college_image')) {

                // Delete old image
                if ($education->college_image && Storage::disk('public')->exists($education->college_image)) {
                    Storage::disk('public')->delete($education->college_image);
                }

                // Store new image
                $imagePath = $request->file('college_image')
                                    ->store('education_logos', 'public');

                $education->college_image = $imagePath;
            }

            // ✅ Update fields
            $education->update([
                'college_name' => $request->college_name,
                'course'       => $request->course,
                'duration'     => $request->duration,
                'college_link' => $request->college_link,
            ]);

            return redirect()->route('education')
                ->with('success', 'Education record updated successfully.');

        } catch (Exception $e) {

            Log::error('Education Update Error', [
                'message' => $e->getMessage(),
                'id' => $id
            ]);

            return back()
                ->withInput()
                ->with('error', 'Something went wrong while updating education.');
        }
    }


    public function deleteEducation($id)
    {
        try {
            $education = Education::findOrFail($id);

            // ✅ Delete image from storage if exists
            if ($education->college_image && Storage::disk('public')->exists($education->college_image)) {
                Storage::disk('public')->delete($education->college_image);
            }

            // ✅ Delete record from database
            $education->delete();

            return redirect()->route('education')
                ->with('success', 'Education record deleted successfully.');

        } catch (Exception $e) {

            // ✅ Log error
            Log::error('Education Delete Error', [
                'message' => $e->getMessage(),
                'id' => $id
            ]);

            return redirect()->route('education')
                ->with('error', 'Failed to delete education record.');
        }
    }
}
