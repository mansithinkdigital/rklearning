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
        return view('client.index');
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
        $user = Auth::user();
        $hasPurchased = $user ? $user->courses()->where('course_id', $course->id)->exists() : false;

        return view('client.course-detail', compact('course', 'hasPurchased'));
    }

    public function contact()
    {
        return view('client.contact');
    }
}
