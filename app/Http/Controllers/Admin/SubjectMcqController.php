<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\CourseMcq;
use Illuminate\Http\Request;

class SubjectMcqController extends Controller
{
    public function index(Subject $subject)
    {
        $subject->load('course');
        $mcqs = CourseMcq::where('subject_id', $subject->id)->latest()->get();
        return view('admin.pages.subject_mcq.index', compact('subject', 'mcqs'));
    }

    public function storeMultiple(Request $request, Subject $subject)
    {
        $request->validate([
            'mcqs' => 'required|array|min:1',
            'mcqs.*.question' => 'required|string|max:500',
            'mcqs.*.options' => 'required|array|min:2',
            'mcqs.*.options.*' => 'required|string|max:255',
            'mcqs.*.answer' => 'required|string',
        ]);

        foreach ($request->mcqs as $mcqData) {
            CourseMcq::create([
                'course_id' => $subject->course_id,
                'subject_id' => $subject->id,
                'question' => $mcqData['question'],
                'options' => array_values($mcqData['options']),
                'answer' => $mcqData['answer'],
            ]);
        }

        return redirect()->back()->with('success', 'MCQs added successfully.');
    }
}
