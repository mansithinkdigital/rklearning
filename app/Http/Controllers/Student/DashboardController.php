<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
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
        $enrolledCourses = $user->courses()->withCount('subjects')->get();
        $availableCourses = Course::where('status', 'Active')
            ->whereNotIn('id', $enrolledCourses->pluck('id')->toArray())
            ->latest()
            ->get();

        return view('student.courses.index', compact('user', 'enrolledCourses', 'availableCourses'));
    }

    public function purchaseCourse(Course $course)
    {
        $user = Auth::user();

        if ($user->courses()->where('course_id', $course->id)->exists()) {
            return back()->with('info', 'You already enrolled in this course.');
        }

        $user->courses()->attach($course->id);

        return back()->with('success', 'Course purchased successfully.');
    }

    /**
     * Display student profile.
     */
    public function profile()
    {
        $user = Auth::user();
        return view('student.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5048'
        ]);

        $imagePath = $user->image;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->extension();
            $image->move(public_path('student/uploads/registerimg'), $imageName);
            $imagePath = 'student/uploads/registerimg/' . $imageName;
        }

        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'image' => $imagePath,
        ]);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function learning($course_id)
    {
        $user = Auth::user();
        // In real app, fetch course and current progress here
        return view('student.learning.player', compact('user', 'course_id'));
    }

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
