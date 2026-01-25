<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Exception;

class SkillsController extends Controller
{
    public function showSkills()
    {
        $skills = Skill::latest()->get();
        return view('pages.skills.index', compact('skills'));
    }

    public function addSkill()
    {
        return view('pages.skills.add');
    }

   public function storeSkill(Request $request)
    {
        $request->validate([
            'section_title'   => 'required|string|max:255',
            'section_content' => 'required|string',
            'name'            => 'required|array|min:1',
            'name.*'          => 'required|string|max:255',
            'image.*'         => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        try {
            $skill_data = [];

            foreach ($request->name as $index => $name) {
                $path = $request->file("image")[$index]->store('skills', 'public');
                $skill_data[] = [
                    'name' => $name,
                    'image' => $path
                ];
            }

            Skill::create([
                'section_title'   => $request->section_title,
                'section_content' => $request->section_content,
                'skill_data'      => $skill_data, 
            ]);

            return redirect()->route('skills')->with('success', 'Skills saved successfully!');
        } catch (Exception $e) {
            Log::error('Bulk Store Error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error saving skills.');
        }
    }


    public function editSkill($id)
    {
        try {
            $skill = Skill::findOrFail($id); //
            return view('pages.skills.edit', compact('skill'));
        } catch (Exception $e) {
            Log::error('Skill Edit Error: ' . $e->getMessage()); //
            return redirect()->route('skills')->with('error', 'Skill not found.');
        }
    }

    public function updateSkill(Request $request, $id)
    {
        $skill = Skill::findOrFail($id);
        $existing_data = $skill->skill_data;

        $request->validate([
            'section_title'   => 'required|string|max:255',
            'section_content' => 'required|string',
            'name'            => 'required|array|min:1',
        ]);

        try {
            $updated_skill_data = [];

            foreach ($request->name as $index => $name) {
                $imagePath = isset($existing_data[$index]) ? $existing_data[$index]['image'] : null;

                if ($request->hasFile("image.$index")) {
                    if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                        Storage::disk('public')->delete($imagePath);
                    }
                    $imagePath = $request->file("image")[$index]->store('skills', 'public');
                }

                $updated_skill_data[] = [
                    'name'  => $name,
                    'image' => $imagePath
                ];
            }

            $skill->update([
                'section_title'   => $request->section_title,
                'section_content' => $request->section_content,
                'skill_data'      => $updated_skill_data,
            ]);

            return redirect()->route('skills')->with('success', 'Skills updated successfully!');
        } catch (Exception $e) {
            Log::error('Bulk Update Error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update skills.');
        }
    }

    public function deleteSkill($id)
    {
        try {
            $skill = Skill::findOrFail($id);

            if ($skill->image && Storage::disk('public')->exists($skill->image)) {
                Storage::disk('public')->delete($skill->image);
            }

            $skill->delete();

            return redirect()->route('skills')->with('success', 'Skill and logo deleted successfully!');

        } catch (Exception $e) {
            Log::error('Skill Delete Error: ' . $e->getMessage(), ['id' => $id]); //
            return redirect()->route('skills')->with('error', 'Something went wrong while deleting.');
        }
    }
}