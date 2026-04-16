<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Unit;
use App\Models\Subject;

class PaidVideoController extends Controller
{
    public function index()
    {
        $videos = \App\Models\PaidVideo::with(['course', 'unit'])->latest()->get();
        $courses = \App\Models\Course::all();
        $subjects = Subject::all();
        $units = Unit::all();
        return view('admin.pages.paidvideo.index', compact('videos', 'courses', 'subjects', 'units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'unit_id' => 'required|exists:units,id',
            'title' => 'required|string|max:255',
            'video_url' => 'required|url',
            'pdf' => 'required|file|mimes:pdf|max:10240',
        ]);
        $data = $request->except(['unit']);
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
            'unit_id' => 'required|exists:units,id',
            'title' => 'required|string|max:255',
            'video_url' => 'required|url',
            'pdf' => 'nullable|file|mimes:pdf|max:10240',
        ]);
        $video = \App\Models\PaidVideo::findOrFail($id);
        $data = $request->except(['unit']);
        if ($request->hasFile('pdf')) {
            // Delete old file if exists
            if ($video->pdf && file_exists(public_path($video->pdf))) {
                unlink(public_path($video->pdf));
            }
            $file = $request->file('pdf');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('admin/uploads/paidpdf'), $filename);
            $data['pdf'] = 'admin/uploads/paidpdf/' . $filename;
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

    public function getUnits($subject_id)
    {
        $units = Unit::where('subject_id', $subject_id)->get();
        return response()->json($units);
    }
}
