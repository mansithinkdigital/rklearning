<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display student dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        return view('student.dashboard', compact('user'));
    }

    /**
     * Display enrolled courses.
     */
    public function courses()
    {
        $user = Auth::user();
        return view('student.courses.index', compact('user'));
    }

    /**
     * Display student profile.
     */
    public function profile()
    {
        $user = Auth::user();
        return view('student.profile', compact('user'));
    }

    /**
     * Display the course learning player.
     */
    public function learning($course_id)
    {
        $user = Auth::user();
        // In real app, fetch course and current progress here
        return view('student.learning.player', compact('user', 'course_id'));
    }

    /**
     * Display the exam portal.
     */
    public function exams()
    {
        $user = Auth::user();
        return view('student.exams.index', compact('user'));
    }

    /**
     * Display fee history.
     */
    public function financials()
    {
        $user = Auth::user();
        return view('student.financials.index', compact('user'));
    }
}
