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
    public function index()
    {
        $results = ExamResult::with(['user', 'courseSubject.course', 'courseSubject.subject'])
            ->latest()
            ->paginate(15);

        return view('admin.pages.exam_results.index', compact('results'));
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
}
