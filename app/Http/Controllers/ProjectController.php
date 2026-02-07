<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;

class ProjectController extends Controller
{
    public function showProjects()
    {
        $projects = Project::latest()->get();
        return view('pages.projects.index', compact('projects'));
    }

    public function addProjects()
    {
        return view('pages.projects.add');
    }

    public function storeProjects(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'link'         => 'required|url',
            'github_link'  => 'required|url',
            'image'        => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tech_name.*'  => 'required|string|max:100',
            'tech_icon.*'  => 'required|image|mimes:png,jpg,jpeg,svg,webp|max:1024',
        ], [
            // Custom messages for empty fields
            'title.required' => 'The project title cannot be empty.',
            'image.required' => 'Please upload a project thumbnail.',
            'tech_name.*.required' => 'Each technology must have a name.',
        ]);
        try {
            /** ---------- Main Image Upload ---------- */
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('projects', 'public');
            }

            /** ---------- Technologies Handling ---------- */
            $technologies = [];

            if ($request->tech_name) {
                foreach ($request->tech_name as $index => $techName) {
                    if (!$techName) continue;

                    $iconPath = null;
                    if (isset($request->tech_icon[$index])) {
                        $iconPath = $request->tech_icon[$index]
                            ->store('projects/tech', 'public');
                    }

                    $technologies[] = [
                        'name' => $techName,
                        'icon' => $iconPath,
                    ];
                }
            }

            /** ---------- Store Project ---------- */
            Project::create([
                'title' => $request->title,
                'description' => $request->description,
                'link' => $request->link,
                'github_link' => $request->github_link,
                'image' => $imagePath,
                'technologies' => $technologies,
            ]);

            return redirect()
                ->route('projects')
                ->with('success', 'Project added successfully');

        } catch (Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Something went wrong!');
        }
    }

    public function editProjects($id)
    {
        $project = Project::findOrFail($id);
        return view('pages.projects.edit', compact('project'));
    }

    public function updateProjects(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'link'         => 'required|url',
            'github_link'  => 'required|url',

            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'tech_name'    => 'required|array|min:1',
            'tech_name.*'  => 'required|string|max:100',

            'tech_icon.*'  => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:1024',
        ]);

        try {

            /** ---------- MAIN IMAGE ---------- */
            $imagePath = $project->image;

            if ($request->hasFile('image')) {
                // delete old image
                if ($project->image) {
                    Storage::disk('public')->delete($project->image);
                }

                $imagePath = $request->file('image')
                    ->store('projects', 'public');
            }

            /** ---------- TECHNOLOGIES ---------- */
            $oldTech = $project->technologies ?? [];
            $technologies = [];

            foreach ($request->tech_name as $index => $techName) {

                // keep old icon if new one not uploaded
                $iconPath = $oldTech[$index]['icon'] ?? null;

                if (isset($request->tech_icon[$index])) {
                    // delete old icon if exists
                    if ($iconPath) {
                        Storage::disk('public')->delete($iconPath);
                    }

                    $iconPath = $request->tech_icon[$index]
                        ->store('projects/tech', 'public');
                }

                $technologies[] = [
                    'name' => $techName,
                    'icon' => $iconPath,
                ];
            }

            /** ---------- UPDATE PROJECT ---------- */
            $project->update([
                'title'        => $request->title,
                'description'  => $request->description,
                'link'         => $request->link,
                'github_link'  => $request->github_link,
                'image'        => $imagePath,
                'technologies' => $technologies,
            ]);

            return redirect()
                ->route('projects')
                ->with('success', 'Project updated successfully 🚀');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Update failed. Please try again.');
        }
    }





    public function deleteProjects($id)
    {
        $project = Project::findOrFail($id);

        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }

        foreach ($project->technologies ?? [] as $tech) {
            if (!empty($tech['icon'])) {
                Storage::disk('public')->delete($tech['icon']);
            }
        }

        $project->delete();

        return redirect()
            ->route('projects')
            ->with('success', 'Project deleted successfully');
    }
}
