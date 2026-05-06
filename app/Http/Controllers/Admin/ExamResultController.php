<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExamResult;
use App\Models\User;
use Illuminate\Http\Request;

class ExamResultController extends Controller
{
    /**
     * Display a listing of all exam results.
     */
    public function index(Request $request)
    {
        $query = ExamResult::with(['user', 'courseSubject.course', 'courseSubject.subject']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('course_id')) {
            $query->whereHas('courseSubject', function($q) use ($request) {
                $q->where('course_id', $request->course_id);
            });
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $results = $query->latest()->paginate(15)->withQueryString();
        $allCourses = \App\Models\Course::all();

        return view('admin.pages.exam_results.index', compact('results', 'allCourses'));
    }

    /**
     * Display the specified exam result details.
     */
    public function show($id)
    {
        $result = ExamResult::with(['user', 'courseSubject.course', 'courseSubject.subject', 'courseSubject.mcqs'])
            ->findOrFail($id);

        return view('admin.pages.exam_results.show', compact('result'));
    }

    public function studentResults($user_id)
    {
        $user = User::findOrFail($user_id);
        $results = ExamResult::where('user_id', $user_id)
            ->with(['courseSubject.course', 'courseSubject.subject'])
            ->latest()
            ->get();

        return view('admin.pages.exam_results.student_results', compact('user', 'results'));
    }

    public function allowReattempt($id)
    {
        $result = ExamResult::findOrFail($id);
        $result->update(['reattempt_status' => 'allowed']);

        return back()->with('success', 'Reattempt permission granted to the student.');
    }
}
