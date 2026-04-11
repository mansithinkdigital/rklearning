<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaidVideoController extends Controller
{
    public function index()
    {
        $videos = \App\Models\PaidVideo::with('course')->latest()->get();
        $courses = \App\Models\Course::all();
        return view('admin.pages.paidvideo.index', compact('videos', 'courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'video_url' => 'required|url',
            'unit' => 'required|string|max:255',
            'pdf' => 'required|file|mimes:pdf|max:10240',
        ]);
        $data = $request->all();
        if ($request->hasFile('pdf')) {
            $file = $request->file('pdf');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('admin/uploads/paidpdf'), $filename);
            $data['pdf'] = 'admin/uploads/paidpdf/' . $filename;
        }
        \App\Models\PaidVideo::create($data);
        return redirect()->back()->with('success', 'Paid video added successfully.');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'video_url' => 'required|url',
            'unit' => 'required|string|max:255',
            'pdf' => 'nullable|file|mimes:pdf|max:10240',
        ]);
        $video = \App\Models\PaidVideo::findOrFail($id);
        $data = $request->all();
        if ($request->hasFile('pdf')) {
            // Delete old file if exists
            if ($video->pdf && file_exists(public_path($video->pdf))) {
                unlink(public_path($video->pdf));
            }
            $file = $request->file('pdf');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('admin/uploads/paidpdf'), $filename);
            $data['pdf'] = 'admin/uploads/paidpdf/' . $filename;
        } else {
            $data['pdf'] = $video->pdf;
        }
        $video->update($data);
        return redirect()->back()->with('success', 'Paid video updated successfully.');
    }

    public function destroy(string $id)
    {
        $video = \App\Models\PaidVideo::findOrFail($id);
        // Delete file if exists
        if ($video->pdf && file_exists(public_path($video->pdf))) {
            unlink(public_path($video->pdf));
        }
        $video->delete();
        return redirect()->back()->with('success', 'Paid video deleted successfully.');
    }
}
