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
        $enrolledCourses = $user->courses()->withCount('subjects')->latest()->take(5)->get();
        $activeCoursesCount = $enrolledCourses->count();
        $certificatesCount = 0;
        $attendancePercentage = 100;
        $latestCourse = $enrolledCourses->first();

        $announcements = [];
        if ($enrolledCourses->isNotEmpty()) {
            $announcements[] = [
                'type' => 'exam',
                'label' => 'Exam',
                'title' => "Quiz Available for {$latestCourse->name}",
                'description' => 'One of your enrolled courses has a new assessment ready. Stay ahead with the latest lesson.',
                'date' => now()->addDays(3)->format('M d, Y'),
                'link' => route('student.exams'),
                'linkLabel' => 'Go to Quiz',
            ];
            $announcements[] = [
                'type' => 'quiz',
                'label' => 'Quiz',
                'title' => "New Practice Material for {$latestCourse->name}",
                'description' => 'A fresh practice quiz has been added for your current course. Sharpen your skills today.',
                'date' => now()->addWeek()->format('M d, Y'),
                'link' => route('student.exams'),
                'linkLabel' => 'Start Quiz',
            ];
        } else {
            $announcements[] = [
                'type' => 'info',
                'label' => 'Info',
                'title' => 'Enroll in Your First Course',
                'description' => 'Browse available courses and enroll to unlock study materials, quizzes, and certificates.',
                'date' => now()->format('M d, Y'),
                'link' => route('courses'),
                'linkLabel' => 'Browse Courses',
            ];
            $announcements[] = [
                'type' => 'survey',
                'label' => 'Update',
                'title' => 'Complete Your Profile',
                'description' => 'A complete profile helps us recommend the best courses and certificates for you.',
                'date' => now()->addDay()->format('M d, Y'),
                'link' => route('student.profile'),
                'linkLabel' => 'Update Profile',
            ];
        }

        $recentPayments = $this->getPaymentHistory($enrolledCourses);
        $totalCourseFee = 12000;
        $totalPaid = collect($recentPayments)->sum('amount');
        $remainingBalance = max(0, $totalCourseFee - $totalPaid);
        $pendingFees = $remainingBalance;

        return view('student.dashboard', compact(
            'user',
            'enrolledCourses',
            'activeCoursesCount',
            'certificatesCount',
            'attendancePercentage',
            'announcements',
            'recentPayments',
            'totalCourseFee',
            'totalPaid',
            'remainingBalance',
            'pendingFees',
            'latestCourse'
        ));
    }

    /**
     * Display enrolled courses.
     */
    public function courses()
    {
        $user = Auth::user();
        $enrolledCourses = $user->courses()->withCount('subjects')->with('paidVideos')->get();
        $availableCourses = Course::where('status', 'Active')
            ->whereNotIn('id', $enrolledCourses->pluck('id')->toArray())
            ->latest()
            ->get();

        return view('student.courses.index', compact('user', 'enrolledCourses', 'availableCourses'));
    }

    public function checkout(Course $course)
    {
        $user = Auth::user();
        if ($user->courses()->where('course_id', $course->id)->exists()) {
            return redirect()->route('student.learning', $course->id)->with('info', 'You already enrolled in this course.');
        }

        return view('client.checkout', compact('user', 'course'));
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
            $path = public_path('student/uploads/registerimg');
            
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            
            $image->move($path, $imageName);
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
        $course = Course::with([
            'subjects.units.topics',
            'subjects.units.paidVideos',
            'subjects.units.freePdfs'
        ])->findOrFail($course_id);
        
        return view('student.learning.player', compact('user', 'course'));
    }

    public function exams()
    {
        $user = Auth::user();
        $enrolledCourses = $user->courses()->get();
        
        $courseSubjects = \App\Models\CourseSubject::whereIn('course_id', $enrolledCourses->pluck('id'))
            ->with(['subject', 'course', 'mcqs'])
            ->get();

        return view('student.exams.index', compact('user', 'courseSubjects'));
    }

    /**
     * Display fee history.
     */
    public function financials()
    {
        $user = Auth::user();
        $recentPayments = $this->getPaymentHistory();
        $totalCourseFee = 12000;
        $totalPaid = collect($recentPayments)->sum('amount');
        $remainingBalance = $totalCourseFee - $totalPaid;

        return view('student.financials.index', compact('user', 'recentPayments', 'totalCourseFee', 'totalPaid', 'remainingBalance'));
    }

    public function downloadReceipt($reference)
    {
        $payments = $this->getPaymentHistory();
        $payment = collect($payments)->firstWhere('reference', $reference);

        if (! $payment) {
            abort(404);
        }

        $content = "Receipt Reference: {$payment['reference']}\n" .
            "Description: {$payment['description']}\n" .
            "Course: {$payment['course']}\n" .
            "Payment Method: {$payment['method']}\n" .
            "Date: {$payment['date']}\n" .
            "Amount: INR {$payment['amount']}\n";

        return response()->streamDownload(function () use ($content) {
            echo $content;
        }, "receipt-{$payment['reference']}.txt", [
            'Content-Type' => 'text/plain',
        ]);
    }

    private function getPaymentHistory($enrolledCourses = null)
    {
        $courseName = null;
        if ($enrolledCourses && $enrolledCourses->isNotEmpty()) {
            $courseName = $enrolledCourses->first()->name;
        }

        return [
            [
                'reference' => 'RK-PAY-45920',
                'description' => 'Admission Fee + Term 1',
                'course' => $courseName ?? 'Professional Tally Prime',
                'method' => 'OFFLINE',
                'date' => '12 Feb, 2026',
                'amount' => 5500,
                'status' => 'Paid',
            ],
            [
                'reference' => 'RK-PAY-46812',
                'description' => 'Monthly Installment - March',
                'course' => $courseName ?? 'Professional Tally Prime',
                'method' => 'ONLINE',
                'date' => '05 Mar, 2026',
                'amount' => 2500,
                'status' => 'Paid',
            ],
        ];
    }
}
