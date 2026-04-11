<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseSubject;
use App\Models\Course;
use App\Models\Subject;
use Illuminate\Http\Request;

class CourseSubjectController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        $courseSubjects = CourseSubject::with(['course', 'subject'])->latest()->get();
        return view('admin.pages.coursesubject.index', compact('courses', 'courseSubjects'));
    }

    public function getSubjects($course_id)
    {
        $subjects = Subject::where('course_id', $course_id)->get(['id', 'name']);
        return response()->json($subjects);
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id'  => 'required|exists:courses,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $exists = CourseSubject::where('course_id', $request->course_id)
            ->where('subject_id', $request->subject_id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'This course and subject combination already exists.');
        }

        CourseSubject::create([
            'course_id'  => $request->course_id,
            'subject_id' => $request->subject_id,
        ]);

        return back()->with('success', 'Course and Subject added successfully.');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'course_id'  => 'required|exists:courses,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $courseSubject = CourseSubject::findOrFail($id);

        $exists = CourseSubject::where('course_id', $request->course_id)
            ->where('subject_id', $request->subject_id)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'This course and subject combination already exists.');
        }

        $courseSubject->update([
            'course_id'  => $request->course_id,
            'subject_id' => $request->subject_id,
        ]);

        return back()->with('success', 'Course and Subject updated successfully.');
    }

    public function destroy(string $id)
    {
        CourseSubject::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Deleted successfully.');
    }
}
