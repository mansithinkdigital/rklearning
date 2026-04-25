<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\FreeVideo;
use App\Models\Freepdf;
use App\Models\PaidVideo;
use App\Models\Topic;
use App\Models\CourseSubject;
use App\Models\ExamResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class DashboardController extends Controller
{
    /**
     * Display student dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Fetch approved courses
        $enrolledCourses = $user->courses()
            ->wherePivot('status', 'approved')
            ->withCount('subjects')
            ->latest()
            ->take(5)
            ->get()
            ->map(function($course) {
                $startDate = $course->pivot->updated_at ?? $course->pivot->created_at;
                $course->expiry_date = $this->calculateExpiryDate($startDate, $course->duration);
                $course->days_remaining = $course->expiry_date ? now()->diffInDays($course->expiry_date, false) : 0;
                $course->is_expired = $course->expiry_date && $course->expiry_date->isPast();
                return $course;
            });

        // Fetch free contents for dashboard quick access
        $freeVideosCount = FreeVideo::count();
        $freePdfsCount = Freepdf::count();

        // Fetch pending (offline) requests
        $pendingRequests = $user->courses()
            ->wherePivot('status', 'pending')
            ->latest()
            ->get();

        $activeCoursesCount = $enrolledCourses->where('is_expired', false)->count();
        $certificatesCount = 0;
        $attendancePercentage = 100;
        $latestCourse = $enrolledCourses->where('is_expired', false)->first();

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
        }

        // Fetch actual transactions from enrollment pivot table
        $recentPayments = $this->getRealPaymentHistory($user, 5);

        $totalPaid = $recentPayments->where('status', 'Approved')->sum('amount');
        $pendingFees = $recentPayments->where('status', 'Pending')->sum('amount');

        return view('student.dashboard', compact(
            'user',
            'enrolledCourses',
            'pendingRequests',
            'activeCoursesCount',
            'certificatesCount',
            'attendancePercentage',
            'announcements',
            'recentPayments',
            'pendingFees',
            'latestCourse',
            'freeVideosCount',
            'freePdfsCount'
        ));
    }

    /**
     * Display enrolled courses.
     */
    public function courses()
    {
        $user = Auth::user();
        
        // Fetch approved courses
        $enrolledCourses = $user->courses()
            ->wherePivot('status', 'approved')
            ->withCount('subjects')
            ->with('paidVideos')
            ->get()
            ->map(function($course) {
                $startDate = $course->pivot->updated_at ?? $course->pivot->created_at;
                $course->expiry_date = $this->calculateExpiryDate($startDate, $course->duration);
                $course->days_remaining = $course->expiry_date ? now()->diffInDays($course->expiry_date, false) : 0;
                $course->is_expired = $course->expiry_date && $course->expiry_date->isPast();
                return $course;
            });

        // Fetch pending (offline) requests
        $pendingCourses = $user->courses()
            ->wherePivot('status', 'pending')
            ->withCount('subjects')
            ->get();

        $availableCourses = Course::where('status', 'Active')
            ->whereNotIn('id', $user->courses()->pluck('course_id')->toArray())
            ->latest()
            ->get();

        return view('student.courses.index', compact('user', 'enrolledCourses', 'pendingCourses', 'availableCourses'));
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

        // Access Control: Check Expiry
        $enrollment = $user->courses()->where('course_id', $course_id)->first();
        if ($enrollment) {
            $startDate = $enrollment->pivot->updated_at ?? $enrollment->pivot->created_at;
            $expiryDate = $this->calculateExpiryDate($startDate, $enrollment->duration);
            if ($expiryDate && $expiryDate->isPast()) {
                return redirect()->route('student.courses')->with('error', 'Your access to this course has expired.');
            }
        }
        
        return view('student.learning.player', compact('user', 'course'));
    }

    public function exams()
    {
        $user = Auth::user();
        
        // Fetch only non-expired enrolled courses
        $enrolledCourses = $user->courses()
            ->wherePivot('status', 'approved')
            ->get()
            ->map(function($course) {
                $startDate = $course->pivot->updated_at ?? $course->pivot->created_at;
                $course->expiry_date = $this->calculateExpiryDate($startDate, $course->duration);
                $course->is_expired = $course->expiry_date && $course->expiry_date->isPast();
                return $course;
            });
        
        $courseSubjects = \App\Models\CourseSubject::whereIn('course_id', $enrolledCourses->pluck('id'))
            ->with(['subject', 'course', 'mcqs'])
            ->get()
            ->map(function($cs) use ($enrolledCourses) {
                $parentCourse = $enrolledCourses->firstWhere('id', $cs->course_id);
                $cs->is_expired = $parentCourse ? $parentCourse->is_expired : false;
                return $cs;
            });

        // Attach results if any
        foreach($courseSubjects as $cs) {
            $cs->result = ExamResult::where('user_id', $user->id)
                ->where('course_subject_id', $cs->id)
                ->first();
        }

        return view('student.exams.index', compact('user', 'courseSubjects'));
    }

    public function startExam($course_subject_id)
    {
        $user = Auth::user();
        $courseSubject = CourseSubject::with(['course', 'subject', 'mcqs'])->findOrFail($course_subject_id);

        // Security Check: Is student enrolled?
        $isEnrolled = $user->courses()->where('courses.id', $courseSubject->course_id)->exists();
        if (!$isEnrolled) {
            return redirect()->route('student.exams')->with('error', 'Unauthorized access.');
        }

        // Check if exam already taken
        $previousResult = ExamResult::where('user_id', $user->id)
            ->where('course_subject_id', $course_subject_id)
            ->first();
        
        if ($previousResult) {
            return redirect()->route('student.exams')->with('error', 'You have already completed this examination.');
        }

        if ($courseSubject->mcqs->isEmpty()) {
            return redirect()->route('student.exams')->with('error', 'No questions available for this subject.');
        }

        // Compute time limit: use stored value, or fallback 2 min per question
        $timeLimit = ($courseSubject->time_limit > 0)
            ? $courseSubject->time_limit
            : ($courseSubject->mcqs->count() * 2);

        return view('student.exams.portal', compact('user', 'courseSubject', 'timeLimit'));
    }

    public function submitExam(Request $request, $course_subject_id)
    {
        $user = Auth::user();
        $courseSubject = CourseSubject::with('mcqs')->findOrFail($course_subject_id);
        
        // Security Check
        $isEnrolled = $user->courses()->where('courses.id', $courseSubject->course_id)->exists();
        if (!$isEnrolled) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $answers = $request->input('answers', []);
        $correctCount = 0;
        $totalQuestions = $courseSubject->mcqs->count();

        foreach ($courseSubject->mcqs as $mcq) {
            $studentAnswer = $answers[$mcq->id] ?? null;
            if ($studentAnswer == $mcq->answer) {
                $correctCount++;
            }
        }

        $score = ($totalQuestions > 0) ? ($correctCount / $totalQuestions) * 100 : 0;
        $status = ($score >= ($courseSubject->pass_marks / ($courseSubject->total_marks ?: 1) * 100)) ? 'pass' : 'fail';
        
        // Handle case where pass_marks might be zero or unset
        if($courseSubject->pass_marks > 0) {
            $status = ($correctCount * ($courseSubject->total_marks / $totalQuestions) >= $courseSubject->pass_marks) ? 'pass' : 'fail';
        } else {
            // Default 40% pass if marks not set properly
            $status = ($score >= 40) ? 'pass' : 'fail';
        }

        $result = ExamResult::create([
            'user_id'           => $user->id,
            'course_subject_id' => $course_subject_id,
            'total_questions'   => $totalQuestions,
            'correct_answers'   => $correctCount,
            'score'             => $score,
            'status'            => $status,
            'student_answers'   => $answers,
        ]);

        $message = $status === 'pass'
            ? "🎉 Congratulations! You passed with {$correctCount}/{$totalQuestions} correct answers ({$score}%)."
            : "❌ You scored {$score}% ({$correctCount}/{$totalQuestions} correct). Better luck next time!";

        if (request()->wantsJson() || request()->header('Accept') === 'application/json') {
            return response()->json([
                'success'  => true,
                'message'  => $message,
                'redirect' => route('student.exams.result', $course_subject_id),
            ]);
        }

        return redirect()->route('student.exams.result', $course_subject_id)->with('success', $message);
    }

    public function viewResult($course_subject_id)
    {
        $user = Auth::user();
        $courseSubject = CourseSubject::with(['course', 'subject', 'mcqs'])->findOrFail($course_subject_id);
        
        $result = ExamResult::where('user_id', $user->id)
            ->where('course_subject_id', $course_subject_id)
            ->first();

        if (!$result) {
            return redirect()->route('student.exams')->with('error', 'Result not found.');
        }

        return view('student.exams.result', compact('user', 'courseSubject', 'result'));
    }

    /**
     * Display fee history.
     */
    public function financials()
    {
        $user = Auth::user();
        $recentPayments = $this->getRealPaymentHistory($user);

        $totalCourseFee = $user->courses()->sum('price');
        $totalPaid = $recentPayments->where('status', 'Approved')->sum('amount');
        $remainingBalance = max(0, $totalCourseFee - $totalPaid);

        return view('student.financials.index', compact('user', 'recentPayments', 'totalCourseFee', 'totalPaid', 'remainingBalance'));
    }

    public function downloadReceipt($reference)
    {
        $user = Auth::user();
        
        // Extract pivot ID from reference (RK-PAY-XXXXX)
        $pivotId = (int) str_replace('RK-PAY-', '', $reference);

        $enrollment = DB::table('course_user')
            ->where('id', $pivotId)
            ->where('user_id', $user->id)
            ->first();

        if (!$enrollment || !$enrollment->receipt_file) {
            // Fallback: If no PDF yet, generate one on the fly if approved
            if ($enrollment && $enrollment->status === 'approved') {
                $course = Course::find($enrollment->course_id);
                $service = new \App\Services\ReceiptService();
                $receiptPath = $service->generateAndSend($user, $course, $enrollment->id);
                return response()->download(public_path($receiptPath));
            }
            abort(404, 'Receipt not available yet.');
        }

        $filePath = public_path($enrollment->receipt_file);
        
        if (!file_exists($filePath)) {
             abort(404, 'Receipt file physically missing.');
        }

        return response()->download($filePath, "Receipt-{$enrollment->receipt_no}.pdf");
    }

    private function calculateExpiryDate($startDate, $duration)
    {
        if (!$startDate) return null;
        
        $date = \Carbon\Carbon::parse($startDate);
        
        if (!$duration) return $date->addYears(1);
        
        $durationLower = strtolower($duration);
        $amount = (int) filter_var($duration, FILTER_SANITIZE_NUMBER_INT);
        if ($amount <= 0) $amount = 1;

        if (str_contains($durationLower, 'month')) {
            return $date->addMonths($amount);
        } elseif (str_contains($durationLower, 'year')) {
            return $date->addYears($amount);
        } elseif (str_contains($durationLower, 'day')) {
            return $date->addDays($amount);
        }
        
        return $date->addYears(1);
    }

    private function getRealPaymentHistory($user, $limit = null)
    {
        $query = $user->courses()
            ->withPivot('id', 'payment_method', 'amount', 'status', 'created_at')
            ->orderBy('course_user.created_at', 'desc');

        if ($limit) {
            $query->take($limit);
        }

        return $query->get()->map(function($course) {
            $startDate = $course->pivot->updated_at ?? $course->pivot->created_at;
            $expiryDate = $this->calculateExpiryDate($startDate, $course->duration);
            $daysLeft = $expiryDate ? now()->diffInDays($expiryDate, false) : 0;

            return [
                'reference' => 'RK-PAY-' . str_pad($course->pivot->id ?? rand(1000, 9999), 5, '0', STR_PAD_LEFT),
                'description' => 'Course Enrollment Fee',
                'id' => $course->pivot->id,
                'course' => $course->name,
                'duration' => $course->duration,
                'method' => strtoupper($course->pivot->payment_method),
                'date' => $course->pivot->created_at ? $course->pivot->created_at->format('d M, Y') : now()->format('d M, Y'),
                'expiry_date' => $expiryDate ? $expiryDate->format('d M, Y') : 'N/A',
                'days_left' => $daysLeft,
                'amount' => $course->pivot->amount,
                'status' => ucfirst($course->pivot->status),
            ];
        });
    }

    public function freeVideos()
    {
        $user = Auth::user();
        $videos = FreeVideo::latest()->get();
        return view('student.free_content.videos', compact('user', 'videos'));
    }

    public function freePdfs()
    {
        $user = Auth::user();
        $pdfs = Freepdf::with('course')->latest()->get();
        return view('student.free_content.pdfs', compact('user', 'pdfs'));
    }

    public function studyMaterial()
    {
        $user = Auth::user();
        // Get courses student has access to
        $enrolledCourseIds = $user->courses()
            ->wherePivot('status', 'approved')
            ->pluck('courses.id');

        // Fetch Study Material from Topics (Subject -> Unit -> Topic)
        $studyMaterials = Topic::whereHas('unit.subject', function($q) use ($enrolledCourseIds) {
                $q->whereIn('course_id', $enrolledCourseIds);
            })
            ->whereNotNull('study_material')
            ->with(['unit.subject.course'])
            ->latest()
            ->get()
            ->filter(function($topic) {
                $course = $topic->unit->subject->course;
                $enrollment = Auth::user()->courses()->where('course_id', $course->id)->first();
                if ($enrollment) {
                    $startDate = $enrollment->pivot->updated_at ?? $enrollment->pivot->created_at;
                    $expiryDate = $this->calculateExpiryDate($startDate, $course->duration);
                    return $expiryDate === null || $expiryDate->isFuture();
                }
                return false;
            });

        return view('student.study_material.index', compact('user', 'studyMaterials'));
    }
}
