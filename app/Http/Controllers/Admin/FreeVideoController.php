<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FreeVideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = \App\Models\FreeVideo::latest()->get();
        return view('admin.pages.freevideo.index', compact('videos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'video_url' => 'required|url',
        ]);

        \App\Models\FreeVideo::create($request->all());

        return redirect()->back()->with('success', 'Video added successfully.');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'video_url' => 'required|url',
        ]);

        $video = \App\Models\FreeVideo::findOrFail($id);
        $video->update($request->all());

        return redirect()->back()->with('success', 'Video updated successfully.');
    }

    public function destroy(string $id)
    {
        $video = \App\Models\FreeVideo::findOrFail($id);
        $video->delete();

        return redirect()->back()->with('success', 'Video deleted successfully.');
    }
}
