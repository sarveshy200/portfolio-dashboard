<?php

namespace App\Http\Controllers;
use App\Models\Header;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Exception;

class HeaderController extends Controller
{
   public function showHeader()
    {
       
        $headers = Header::latest()->get();
        
        return view('pages.header.index', compact('headers'));
    }

    public function addHeader()
    {
        return view('pages.header.add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',

            'social_name' => 'nullable|array',
            'social_name.*' => 'nullable|string|max:100',

            'social_url' => 'nullable|array',
            'social_url.*' => 'nullable|url|max:255',

            'social_icon' => 'nullable|array',
            'social_icon.*' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        try {
            $socialLinks = [];

            if ($request->has('social_name')) {
                foreach ($request->social_name as $index => $name) {

                    $url = $request->social_url[$index] ?? null;

                    // Skip empty rows
                    if (!$name || !$url) {
                        continue;
                    }

                    $iconPath = null;
                    if ($request->hasFile("social_icon.$index")) {
                        $iconPath = $request->file("social_icon.$index")
                            ->store('icons', 'public');
                    }

                    $socialLinks[] = [
                        'name' => $name,
                        'url'  => $url,
                        'icon' => $iconPath,
                    ];
                }
            }

            Header::create([
                'title' => $request->title,
                'content' => $request->content,
                'social_links' => $socialLinks,
            ]);

            return redirect()->route('header')
                ->with('success', 'Header section saved successfully!');

        } catch (Exception $e) {

            Log::error('Header Store Error', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to save header. Please try again.');
        }
    }


    /**
     * Show the form for editing the specified header.
     */
    public function editHeader($id)
    {
        try {
            // Find the header or throw a 404 error
            $header = Header::findOrFail($id);
            
            return view('pages.header.edit', compact('header'));
        } catch (Exception $e) {
            return redirect()->route('header')->with('error', 'Header not found.');
        }
    }

    public function updateHeader(Request $request, $id)
    {
        $header = Header::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        try {
            $socialLinks = [];
            if ($request->has('social_name')) {
                foreach ($request->social_name as $index => $name) {
                    // Determine icon: use new upload or keep the old path
                    $iconPath = $header->social_links[$index]['icon'] ?? null;

                    if ($request->hasFile("social_icon.$index")) {
                        // Delete old icon if it exists
                        if ($iconPath) Storage::disk('public')->delete($iconPath);
                        $iconPath = $request->file("social_icon.$index")->store('icons', 'public');
                    }

                    $socialLinks[] = [
                        'name' => $name,
                        'url'  => $request->social_url[$index] ?? null,
                        'icon' => $iconPath,
                    ];
                }
            }

            $header->update([
                'title' => $request->title,
                'content' => $request->content,
                'social_links' => $socialLinks,
            ]);

            return redirect()->route('header')->with('success', 'Header updated successfully!');

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Update failed: ' . $e->getMessage());
        }
    }


    public function deleteHeader($id)
    {
        try {
            $header = Header::findOrFail($id);

            if (!empty($header->social_links)) {
                foreach ($header->social_links as $link) {
                    if (!empty($link['icon']) && Storage::disk('public')->exists($link['icon'])) {
                        Storage::disk('public')->delete($link['icon']);
                    }
                }
            }

            $header->delete();

            return redirect()->route('header')->with('success', 'Header section and associated icons deleted successfully!');

        } catch (Exception $e) {
            Log::error('Header Delete Error: ' . $e->getMessage());

            return redirect()->route('header')->with('error', 'Failed to delete the header section.');
        }
    }
}
