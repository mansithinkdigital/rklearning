<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseMcq;
use App\Models\CourseSubject;
use Illuminate\Http\Request;

class CourseMcqController extends Controller
{
    public function index(CourseSubject $courseSubject)
    {
        $mcqs = CourseMcq::where('course_subject_id', $courseSubject->id)
            ->latest()
            ->get();
            
        // pass the courseSubject context to view
        return view('admin.pages.coursemcq.index', compact('mcqs', 'courseSubject'));
    }

    public function store(Request $request, CourseSubject $courseSubject)
    {
        $request->validate([
            'question'    => 'required|string|max:500',
            'options'     => 'required|array|min:2',
            'options.*'   => 'required|string|max:255',
            'answer'      => 'required|string',
        ]);

        CourseMcq::create([
            'course_subject_id' => $courseSubject->id,
            'question'          => $request->question,
            'options'    => array_values($request->options),
            'answer'     => $request->answer,
        ]);

        return back()->with('success', 'MCQ added successfully.');
    }

    public function update(Request $request, CourseMcq $courseMcq)
    {
        $request->validate([
            'question'    => 'required|string|max:500',
            'options'     => 'required|array|min:2',
            'options.*'   => 'required|string|max:255',
            'answer'      => 'required|string',
        ]);

        $courseMcq->update([
            'question'   => $request->question,
            'options'    => array_values($request->options),
            'answer'     => $request->answer,
        ]);

        return back()->with('success', 'MCQ updated successfully.');
    }

    public function destroy(CourseMcq $courseMcq)
    {
        $courseMcq->delete();
        return redirect()->back()->with('success', 'MCQ deleted successfully.');
    }
}
