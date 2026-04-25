<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home()
    {
        $courses = Course::where('status', 'Active')
            ->withCount(['subjects', 'students'])
            ->latest()
            ->take(8)
            ->get();

        $totalCourses = Course::where('status', 'Active')->count();
        $totalStudents = Course::where('status', 'Active')
            ->withCount('students')
            ->get()
            ->sum('students_count');
        $totalLessons = Course::where('status', 'Active')
            ->withCount('subjects')
            ->get()
            ->sum('subjects_count');

        return view('client.index', compact('courses', 'totalCourses', 'totalStudents', 'totalLessons'));
    }

    public function about()
    {
        return view('client.about');
    }

    public function courses()
    {
        $courses = Course::where('status', 'Active')->latest()->get();
        return view('client.courses', compact('courses'));
    }

    public function courseDetail(Course $course)
    {
        $course->load(['subjects.units.topics', 'subjects.units.paidVideos', 'subjects.units.freePdfs']);
        $user = Auth::user();
        $enrollment = $user ? $user->courses()->where('course_id', $course->id)->first() : null;
        $hasPurchased = $enrollment && $enrollment->pivot->status === 'approved';
        $isPending = $enrollment && $enrollment->pivot->status === 'pending';

        return view('client.course-detail', compact('course', 'hasPurchased', 'isPending'));
    }

    public function contact()
    {
        return view('client.contact');
    }
}
